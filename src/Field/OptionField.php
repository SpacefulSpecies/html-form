<?php

namespace Species\HtmlForm\Field;

use Species\HtmlForm\Exception\FieldValueNotInOptions;
use Species\HtmlForm\FormOptionField;

/**
 * Implementation of an form option field like select and radio.
 */
final class OptionField extends Field implements FormOptionField
{

    /** @var string[] */
    private $options;

    /** @var string */
    private $name;



    /**
     * @param array $data
     * @return self
     */
    public function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['label'] ?? '',
            $data['options'] ?? [],
            $data['defaultValue'] ?? null,
            $data['required'] ?? null,
            $data['resolver'] ?? null
        );
    }



    /**
     * @param string        $name
     * @param string        $label
     * @param string[]      $options
     * @param string        $defaultValue = null (default: '')
     * @param bool|null     $required     = null (default: false)
     * @param callable|null $resolver     = null
     */
    public function __construct(
        string $name,
        string $label,
        array $options,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?callable $resolver = null
    )
    {
        parent::__construct($name, $label, $defaultValue, $required, $resolver);
        $this->options = $options;
        $this->assertValueInOptions($this->getValue());
        $this->name = $name;
    }



    /** @inheritdoc */
    public function getOptions(): array
    {
        return $this->options;
    }



    /** @inheritdoc */
    public function resolve()
    {
        $this->assertValueInOptions($this->getValue());

        return parent::resolve();
    }



    /**
     * @param string $value
     * @throws FieldValueNotInOptions
     */
    private function assertValueInOptions(string $value): void
    {
        if ($value && !in_array($value, $this->options, true)) {
            throw new FieldValueNotInOptions();
        }
    }

}
