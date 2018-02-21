<?php

namespace Species\HtmlForm;

use Species\HtmlForm\Exception\FieldNameAlreadyExists;
use Species\HtmlForm\Exception\FieldNotFound;
use Species\HtmlForm\Exception\ArrayAccess\ExpectingFormFieldAsValue;
use Species\HtmlForm\Exception\ArrayAccess\ExpectingFormFieldNameAsKey;

/**
 * A collection interface for form fields.
 */
interface FormFields extends \IteratorAggregate, \Countable, \ArrayAccess
{

    /**
     * @param string $fieldName
     * @return bool
     */
    public function has(string $fieldName): bool;

    /**
     * @param string $fieldName
     * @return FormField
     * @throws FieldNotFound
     */
    public function get(string $fieldName): FormField;

    /**
     * @param FormField $field
     * @throws FieldNameAlreadyExists
     */
    public function add(FormField $field): void;

    /**
     * @param string $fieldName
     * @throws FieldNotFound
     */
    public function remove(string $fieldName): void;




    // Override return types and docs of \IteratorAggregate and \ArrayAccess.
    // The $offset of \ArrayAccess is the same as the field name.

    /**
     * @inheritdoc
     * @return \Traversable|FormField[]
     */
    public function getIterator(): \Traversable;



    /**
     * @inheritdoc
     * @param string $offset
     * @return bool
     * @see $this->has($offset)
     */
    public function offsetExists($offset): bool;

    /**
     * @inheritdoc
     * @param string $offset
     * @return FormField
     * @throws FieldNotFound
     * @see $this->get($offset)
     */
    public function offsetGet($offset): FormField;

    /**
     * @inheritdoc
     * @param string    $offset
     * @param FormField $value
     * @throws ExpectingFormFieldNameAsKey
     * @throws ExpectingFormFieldAsValue
     * @throws FieldNameAlreadyExists
     * @see $this->add($value)
     */
    public function offsetSet($offset, $value): void;

    /**
     * @inheritdoc
     * @param string $offset
     * @throws FieldNotFound
     * @see $this->remove($offset)
     */
    public function offsetUnset($offset): void;

}
