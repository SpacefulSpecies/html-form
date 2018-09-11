<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Value\CheckedStringValue;
use Species\HtmlForm\SimpleForm\Exception\FieldIsRequired;
use Species\HtmlForm\SimpleForm\Exception\InvalidValue;

/**
 * Abstract simple check node.
 */
abstract class SimpleCheckNode extends SimpleNode implements LeafNode, CheckedStringValue
{

    /** @var bool */
    private $checked;

    /** @var bool */
    private $default;

    /** @var string */
    private $value;

    /** @var bool */
    private $required;

    /** @var string|null */
    private $error;

    /** @var callable|null */
    private $handler;



    /**
     * @param string        $name
     * @param bool          $checked
     * @param string        $value
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, bool $checked, string $value, bool $required, ?callable $handler)
    {
        parent::__construct($name);

        if ($value === '') {
            $value = 'on';
        }

        $this->value = $value;
        $this->checked = $checked;
        $this->default = $checked;
        $this->required = $required;
        $this->handler = $handler;
    }



    /** @inheritdoc */
    final public function isChecked(): bool
    {
        return $this->checked;
    }

    /** @inheritdoc */
    final public function getCheckedValue(): string
    {
        return $this->value;
    }



    /** @inheritdoc */
    final public function getValue(): string
    {
        return $this->checked ? $this->value : '';
    }

    /** @inheritdoc */
    final public function getDefaultValue(): string
    {
        return $this->default ? $this->value : '';
    }

    /** @inheritdoc */
    final public function isRequired(): bool
    {
        return $this->required;
    }



    /** @inheritdoc */
    final public function getError(): ?string
    {
        return $this->error;
    }



    /** @inheritdoc */
    final public function submit(string $value, array $context = [])
    {
        $this->error = null;
        $this->checked = ($value === $this->value);

        try {

            $value = $this->getValue();

            if ($this->required && !$this->checked) {
                throw new FieldIsRequired();
            }

            return $this->handler ? ($this->handler)($value, $context) : $value;

        } catch (\Throwable $e) {

            $e = InvalidValue::withReason($e);
            $this->error = $e->getMessage();

            throw $e;
        }
    }

    /** @inheritdoc */
    final public function reset(): void
    {
        $this->checked = $this->default;
        $this->error = null;
    }

}
