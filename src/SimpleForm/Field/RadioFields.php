<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlRadioField;
use Species\HtmlForm\Contract\Field\HtmlRadioFields;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleParentNode;
use Species\HtmlForm\SimpleForm\Abstraction\ValueWithOptionsTrait;
use Species\HtmlForm\SimpleForm\Exception\FieldIsRequired;
use Species\HtmlForm\SimpleForm\Exception\InvalidValue;

/**
 * Radio fields.
 */
final class RadioFields extends SimpleParentNode implements HtmlRadioFields
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
     * @param string[]      $options
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(string $name, string $value, array $options, bool $required, ?callable $handler)
    {
        $this->options = $this->validateOptions($options);
        $this->value = $this->validateOptionValue($value);

        $nodes = [];
        foreach ($this->options as $option) {
            $nodes[] = new RadioField($name, $this->value === $option, $option, false, null);
        }

        parent::__construct($name, $nodes);

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

            $submitError = null;
            foreach ($this as $node) {
                if ($node instanceof HtmlRadioField) {
                    try {
                        $node->submit($value);
                    } catch (\Throwable $e) {
                        $submitError = $submitError ?? $e;
                    }
                }
            }

            $this->value = $this->validateOptionValue($value);

            if ($submitError instanceof \Throwable) {
                throw $submitError;
            }
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
        foreach ($this as $node) {
            if ($node instanceof HtmlRadioField) {
                $node->reset();
            }
        }

        $this->value = $this->default;
        $this->error = null;
    }

}
