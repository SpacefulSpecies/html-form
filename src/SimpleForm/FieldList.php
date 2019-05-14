<?php

namespace Species\HtmlForm\SimpleForm;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\HtmlFieldList;
use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\SimpleForm\Abstraction\DelegateValueTrait;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleParentNode;
use Species\HtmlForm\SimpleForm\Exception\FieldIsRequired;

/**
 * Field list.
 */
final class FieldList extends SimpleParentNode implements HtmlFieldList
{

    use DelegateValueTrait;



    /** @var Node */
    private $prototype;

    /** @var array */
    private $defaults;

    /** @var bool */
    private $required;

    /** @var callable */
    private $handler;



    /**
     * @param Node          $prototype
     * @param array         $values
     * @param bool          $required
     * @param callable|null $handler callable(array $values, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(Node $prototype, array $values, bool $required, ?callable $handler)
    {
        parent::__construct($prototype->getShortName(), []);

        $this->prototype = $prototype;
        $this->defaults = $values;
        $this->required = $required;

        $this->handler = function (array $values, array $context) use ($handler) {
            if ($this->required && count($values) === 0) {
                throw new FieldIsRequired();
            }

            return $handler ? $handler($values, $context) : $values;
        };

        $this->prototype->setParent($this);
        $this->reset();
    }



    /** @inheritdoc */
    public function getPrototype(): Node
    {
        return $this->prototype->cloneNode();
    }



    /** @inheritdoc */
    public function getValues(): array
    {
        return $this->getValuesFrom($this);
    }

    /** @inheritdoc */
    public function getDefaultValues(): array
    {
        return $this->defaults;
    }

    /** @inheritdoc */
    public function isRequired(): bool
    {
        return $this->required;
    }



    /** @inheritdoc */
    public function getError(): ?string
    {
        return $this->getDelegateError();
    }

    /** @inheritdoc */
    public function getErrors(): array
    {
        return $this->getErrorsFrom($this);
    }



    /** @inheritdoc */
    public function submit(array $values, array $context = [])
    {
        $recursiveFilterArray = function (array $array) use (&$recursiveFilterArray) {
            foreach ($array as &$value) {
                if (is_array($value)) {
                    $value = $recursiveFilterArray($value);
                }
            }

            return array_filter($array);
        };

        $values = $recursiveFilterArray($values);
        $length = count($values);
        $this->resetListWithLength($length);

        return $this->submitTo($this, $this->handler, $values, $context);
    }

    /**
     * @inheritdoc
     * @throws HtmlInvalidFieldValue
     */
    public function reset(): void
    {
        $this->submit($this->defaults);
    }



    /**
     * @param int $length
     */
    private function resetListWithLength(int $length)
    {
        $nodes = [];
        for (; $length > 0; --$length) {
            $nodes[] = $this->getPrototype();
        }

        $this->setNodes($nodes);
    }

}
