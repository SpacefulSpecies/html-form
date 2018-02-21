<?php

namespace Species\HtmlForm;

use Species\HtmlForm\Exception\InvalidFieldName;
use Species\HtmlForm\Exception\FieldIsRequired;
use Species\HtmlForm\Exception\InvalidFieldValue;

/**
 * Form field interface.
 *
 * @throws InvalidFieldName
 */
interface FormField
{

    /**
     * Get the name of the form field.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the value of the form field.
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Get the default value of the form field.
     *
     * @return string
     */
    public function getDefaultValue(): string;

    /**
     * Whether the form field is required.
     *
     * @return bool
     */
    public function isRequired(): bool;



    /**
     * Submit the form field with given value.
     *
     * @param string $value
     */
    public function submit(string $value): void;

    /**
     * Reset the form field to its default value and return the previous value.
     *
     * @return string
     */
    public function reset(): string;



    /**
     * Return the resolved value that you can use in your domain.
     *
     * @return mixed
     * @throws FieldIsRequired
     * @throws InvalidFieldValue
     */
    public function resolve();

}
