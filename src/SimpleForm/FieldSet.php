<?php

namespace Species\HtmlForm\SimpleForm;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\HtmlFieldSet;
use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\Form\SimpleParentNode;
use Species\HtmlForm\SimpleForm\Abstraction\DelegateValueTrait;

/**
 * Field set.
 */
final class FieldSet extends SimpleParentNode implements HtmlFieldSet
{

    use DelegateValueTrait;



    /** @var callable|null */
    private $handler;



    /**
     * @param string          $name
     * @param Node[]|iterable $nodes
     * @param callable|null   $handler callable(array $values, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, iterable $nodes, ?callable $handler)
    {
        $associativeNodes = [];
        foreach ($nodes as $node) {
            $associativeNodes[$node->getShortName()] = $node;
        }

        parent::__construct($name, $associativeNodes);

        $this->handler = $handler;
    }



    /** @inheritdoc */
    public function getValues(): array
    {
        return $this->getValuesFrom($this);
    }

    /** @inheritdoc */
    public function getDefaultValues(): array
    {
        return $this->getDefaultValuesFrom($this);
    }

    /** @inheritdoc */
    public function isRequired(): bool
    {
        return $this->isRequiredFor($this);
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
        return $this->submitTo($this, $this->handler, $values, $context);
    }

    /** @inheritdoc */
    public function reset(): void
    {
        $this->resetOn($this);
    }

}
