<?php

namespace Species\HtmlForm\Field;

use Species\HtmlForm\Exception\FieldValueNotInOptions;
use Species\HtmlForm\Exception\InvalidFieldOptions;
use Species\HtmlForm\FormOptionField;

/**
 * Implementation of an form option field like select and radio.
 */
final class OptionField extends Field implements FormOptionField
{

    /** @var string[] */
    private $options;



    /**
     * @param array $data
     * @return self
     */
    public function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['options'] ?? [],
            $data['label'] ?? null,
            $data['defaultValue'] ?? null,
            $data['resolver'] ?? null
        );
    }



    /**
     * @param string        $name
     * @param string[]      $options
     * @param string|null   $label        = ''
     * @param string|null   $defaultValue = ''
     * @param callable|null $resolver     = null
     */
    public function __construct(
        string $name,
        array $options,
        ?string $label = '',
        ?string $defaultValue = '',
        ?callable $resolver = null
    )
    {
        $required = !isset($options['']);

        parent::__construct($name, $label, $defaultValue, $required, $resolver);
        $this->options = $options;

        $this->guardValidOptions();
        $this->guardValueInOptions();
    }



    /** @inheritdoc */
    public function getOptions(): array
    {
        return $this->options;
    }



    /** @inheritdoc */
    protected function guardFieldValue(): void
    {
        $this->guardValueInOptions();
    }



    /**
     * @throws InvalidFieldOptions
     */
    private function guardValidOptions(): void
    {
        if (count($this->options) === 0) {
            throw new InvalidFieldOptions();
        }
        foreach ($this->options as $value => $label) {
            if (!is_string($value) || !is_string($label)) {
                throw new InvalidFieldOptions();
            }
        }
    }

    /**
     * @throws FieldValueNotInOptions
     */
    private function guardValueInOptions(): void
    {
        if (!isset($this->options[$this->getValue()])) {
            throw new FieldValueNotInOptions();
        }
    }

}
