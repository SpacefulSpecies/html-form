<?php

namespace Species\HtmlForm;

use Species\HtmlForm\Exception\FieldIsRequired;
use Species\HtmlForm\Exception\InvalidFieldName;
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
     * Get the corresponding label of the form field.
     *
     * @return string
     */
    public function getLabel(): string;

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
     * Reset the form field to its default value and return the previous value.
     *
     * @return string
     */
    public function reset(): string;

    /**
     * Submit the form field with given value and return the resolved value that you can use in your domain.
     *
     * @param string $value
     * @return mixed
     * @throws FieldIsRequired
     * @throws InvalidFieldValue
     */
    public function submit(string $value);

    /**
     * Whether the last submit had an error.
     *
     * @return bool
     */
    public function hasError(): bool;

}
