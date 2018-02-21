<?php

namespace Species\HtmlForm\Field;

use Species\HtmlForm\Exception\ArrayAccess\ExpectingFormFieldAsValue;
use Species\HtmlForm\Exception\FieldNameAlreadyExists;
use Species\HtmlForm\Exception\FieldNotFound;
use Species\HtmlForm\FormField;
use Species\HtmlForm\FormFields;

/**
 * Form field collection implementation.
 */
final class Fields implements FormFields
{

    /** @var FormField[] */
    private $fields = [];



    /**
     * @param array $data
     * @return Fields
     */
    public static function fromArray(array $data): self
    {
        $fields = new self();
        foreach ($data as $name => $fieldData) {
            $fieldData['name'] = $fieldData['name'] ?? $name;
            if (isset($fieldData['options'])) {
                $fields->add(OptionField::fromArray($fieldData));
            } else {
                $fields->add(InputField::fromArray($fieldData));
            }
        }

        return $fields;
    }



    /**
     * @param iterable $fields = []
     */
    public function __construct(iterable $fields = [])
    {
        foreach ($fields as $field) {
            $this->add($field);
        }
    }



    /** @inheritdoc */
    public function has(string $fieldName): bool
    {
        return isset($this->fields[$fieldName]);
    }

    /** @inheritdoc */
    public function get(string $fieldName): FormField
    {
        if (!$this->has($fieldName)) {
            throw new FieldNotFound();
        }

        return $this->fields[$fieldName];
    }

    /** @inheritdoc */
    public function add(FormField $field): void
    {
        $fieldName = $field->getName();
        if ($this->has($fieldName)) {
            throw new FieldNameAlreadyExists();
        }

        $this->fields[$fieldName] = $field;
    }

    /** @inheritdoc */
    public function remove(string $fieldName): void
    {
        if (!$this->has($fieldName)) {
            throw new FieldNotFound();
        }

        unset($this->fields[$fieldName]);
    }



    /** @inheritdoc */
    public function count(): int
    {
        return count($this->fields);
    }

    /**
     * @inheritdoc
     * @yield FormField
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->fields as $field) {
            yield $field;
        }
    }

    /** @inheritdoc */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /** @inheritdoc */
    public function offsetGet($offset): FormField
    {
        return $this->get($offset);
    }

    /** @inheritdoc */
    public function offsetSet($offset, $value): void
    {
        if (!$value instanceof FormField) {
            throw new ExpectingFormFieldAsValue();
        }
        $this->add($value);
    }

    /** @inheritdoc */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

}
