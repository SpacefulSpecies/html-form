<?php

namespace Species\HtmlForm\Field;

use Species\HtmlForm\Exception\FieldValueNotInSet;
use Species\HtmlForm\FormField;

/**
 * Implementation of a form field set like select and radio.
 */
final class FieldSet extends Field implements FormField
{

    /** @var string[] */
    private $values;

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
            $data['values'] ?? [],
            $data['defaultValue'] ?? null,
            $data['required'] ?? null,
            $data['resolver'] ?? null
        );
    }



    /**
     * @param string        $name
     * @param string        $label
     * @param string[]      $values
     * @param string        $defaultValue = null (default: '')
     * @param bool|null     $required     = null (default: false)
     * @param callable|null $resolver     = null
     */
    public function __construct(
        string $name,
        string $label,
        array $values,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?callable $resolver = null
    )
    {
        parent::__construct($name, $label, $defaultValue, $required, $resolver);
        $this->values = $values;
        $this->assertValueInSet($this->getValue());
        $this->name = $name;
    }



    /** @inheritdoc */
    public function getValues(): array
    {
        return $this->values;
    }



    /** @inheritdoc */
    public function resolve()
    {
        $this->assertValueInSet($this->getValue());

        return parent::resolve();
    }



    /**
     * @param string $value
     * @throws FieldValueNotInSet
     */
    private function assertValueInSet(string $value): void
    {
        if ($value && !in_array($value, $this->values, true)) {
            throw new FieldValueNotInSet();
        }
    }

}
