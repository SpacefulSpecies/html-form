<?php

namespace Species\HtmlForm\Contract;

use Species\HtmlForm\Exception\FieldCollectionIsReadOnly;
use Species\HtmlForm\Exception\FieldIsRequired;
use Species\HtmlForm\Exception\FieldNotFound;
use Species\HtmlForm\Exception\InvalidFieldValue;

/**
 * A collection interface for html fields/lists/groups.
 */
interface HtmlFieldCollection extends \IteratorAggregate, \Countable, \ArrayAccess
{

    /**
     * Get the values as an associative array.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Get the default values of the field collection as an associative array.
     *
     * @return array
     */
    public function getDefaultValues(): array;



    /**
     * Reset the fields to its default values and return the previous values as an associative array.
     *
     * @return array
     */
    public function reset(): array;

    /**
     * Submit the field collection with given values in context and
     * return the resolved values that you can use in your domain.
     *
     * @param string[] $value
     * @param array    $context
     * @return mixed
     * @throws FieldIsRequired
     * @throws InvalidFieldValue
     */
    public function submit(array $value, array $context);

    /**
     * Get the error messages from last submit as an associative array.
     *
     * @return array
     */
    public function getErrors(): array;



    // Override return types and docs of \Countable, \IteratorAggregate and \ArrayAccess for IDE support.

    /** @inheritdoc */
    public function count(): int;

    /**
     * @inheritdoc
     * @return HtmlField[]|HtmlFieldList[]|HtmlFieldGroup[]
     */
    public function getIterator(): \Traversable;

    /**
     * @inheritdoc
     * @param string $fieldName
     * @return bool
     */
    public function offsetExists($fieldName): bool;

    /**
     * @inheritdoc
     * @param string $fieldName
     * @return HtmlField|HtmlFieldList|HtmlFieldGroup
     * @throws FieldNotFound
     */
    public function offsetGet($fieldName);

    /**
     * @inheritdoc
     * @throws FieldCollectionIsReadOnly
     */
    public function offsetSet($offset, $value): void;

    /**
     * @inheritdoc
     * @throws FieldCollectionIsReadOnly
     */
    public function offsetUnset($offset): void;

}
