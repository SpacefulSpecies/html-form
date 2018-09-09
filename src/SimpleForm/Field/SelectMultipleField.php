<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlSelectMultipleField;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleNode;
use Species\HtmlForm\SimpleForm\Abstraction\ValueWithOptionsTrait;
use Species\HtmlForm\SimpleForm\Exception\FieldIsRequired;
use Species\HtmlForm\SimpleForm\Exception\InvalidValue;

/**
 * Select multiple field.
 */
final class SelectMultipleField extends SimpleNode implements HtmlSelectMultipleField
{

    use ValueWithOptionsTrait;



    /** @var string[] */
    private $values;

    /** @var string[] */
    private $defaults;

    /** @var bool */
    private $required;

    /** @var callable|null */
    private $handler;

    /** @var string|null */
    private $error;



    /**
     * @param string        $name
     * @param string[]      $values
     * @param array         $options
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(string $name, array $values, array $options, bool $required, ?callable $handler)
    {
        $this->options = $this->validateOptions($options);
        $this->values = array_map(function (string $value) {
            return $this->validateOptionValue($value);
        }, $values);

        parent::__construct($name);

        $this->defaults = $this->values;
        $this->required = $required;
        $this->handler = $handler;
    }



    /** @inheritdoc */
    public function getValues(): array
    {
        return $this->values;
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
        return $this->error;
    }

    /** @inheritdoc */
    public function getErrors(): array
    {
        return array_fill(0, count($this->values), null);
    }



    /** @inheritdoc */
    public function submit(array $values, array $context = [])
    {
        $this->error = null;

        try {
            $this->values = [];

            $error = null;
            foreach ($values as $value) {
                try {
                    $this->values[] = $this->validateOptionValue($value);
                } catch (\Throwable $e) {
                    $error = $error ?? $e;
                }
            }

            if ($error instanceof \Throwable) {
                throw $error;
            }
            if ($this->required && count($this->values) === 0) {
                throw new FieldIsRequired();
            }

            return ($this->handler)($this->values, $context);

        } catch (\Throwable $e) {

            $e = InvalidValue::withReason($e);
            $this->error = $e->getMessage();

            throw $e;
        }
    }

    /** @inheritdoc */
    public function reset(): void
    {
        $this->values = $this->defaults;
        $this->error = null;
    }

}
