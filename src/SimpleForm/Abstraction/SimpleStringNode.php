<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Value\StringValue;
use Species\HtmlForm\SimpleForm\Exception\FieldIsRequired;
use Species\HtmlForm\SimpleForm\Exception\InvalidValue;

/**
 * Abstract simple string node.
 */
abstract class SimpleStringNode extends SimpleNode implements LeafNode, StringValue
{

    /** @var string */
    private $value;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var string|null */
    private $error;

    /** @var callable */
    private $handler;



    /**
     * @param string        $name
     * @param string        $value
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, string $value, bool $required, ?callable $handler)
    {
        parent::__construct($name);

        $this->value = $value;
        $this->default = $value;
        $this->required = $required;

        $this->handler = function (string $value, array $context) use ($handler) {

            $value = StringManipulation::sanitize($value);

            return $handler ? $handler($value, $context) : $value;
        };
    }



    /** @inheritdoc */
    final public function getValue(): string
    {
        return $this->value;
    }

    /** @inheritdoc */
    final public function getDefaultValue(): string
    {
        return $this->default;
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
        $this->value = $value;

        try {

            if ($this->required && StringManipulation::trim($this->value) === '') {
                throw new FieldIsRequired();
            }

            return ($this->handler)($this->value, $context);

        } catch (\Throwable $e) {

            $e = InvalidValue::withReason($e);
            $this->error = $e->getMessage();

            throw $e;
        }
    }

    /** @inheritdoc */
    final public function reset(): void
    {
        $this->value = $this->default;
        $this->error = null;
    }

}
