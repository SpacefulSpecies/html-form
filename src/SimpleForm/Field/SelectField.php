<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlSelectField;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleNode;
use Species\HtmlForm\SimpleForm\Abstraction\ValueWithOptionsTrait;
use Species\HtmlForm\SimpleForm\Exception\FieldIsRequired;
use Species\HtmlForm\SimpleForm\Exception\InvalidValue;

/**
 * Select field.
 */
final class SelectField extends SimpleNode implements HtmlSelectField
{

    use ValueWithOptionsTrait;



    /** @var string */
    private $value;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var callable|null */
    private $handler;

    /** @var string|null */
    private $error;



    /**
     * @param string        $name
     * @param string        $value
     * @param array         $options
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(string $name, string $value, array $options, bool $required, ?callable $handler)
    {
        $this->options = $this->validateOptions($options);
        $this->value = $this->validateOptionValue($value);

        parent::__construct($name);

        $this->default = $this->value;
        $this->required = $required;
        $this->handler = $handler;
    }



    /** @inheritdoc */
    public function getValue(): string
    {
        return $this->value;
    }

    /** @inheritdoc */
    public function getDefaultValue(): string
    {
        return $this->default;
    }

    /** @inheritdoc */
    public function isRequired(): bool
    {
        return $this->required;
    }



    /** @inheritdoc */
    public function getError(): ?string
    {
        return $this->error;
    }



    /** @inheritdoc */
    public function submit(string $value, array $context = [])
    {
        $this->error = null;

        try {

            $this->value = $this->validateOptionValue($value);

            if ($this->required && $this->value === '') {
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
    public function reset(): void
    {
        $this->value = $this->default;
        $this->error = null;
    }

}
