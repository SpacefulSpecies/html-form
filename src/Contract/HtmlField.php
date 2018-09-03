<?php

namespace Species\HtmlForm\Contract;

use Species\HtmlForm\Exception\FieldIsRequired;
use Species\HtmlForm\Exception\InvalidFieldValue;

/**
 * Html field interface.
 */
interface HtmlField extends HtmlFieldName
{

    /**
     * Get the value of the field.
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Get the default value of the field.
     *
     * @return string
     */
    public function getDefaultValue(): string;

    /**
     * Whether the field is required.
     *
     * @return bool
     */
    public function isRequired(): bool;



    /**
     * Reset the field to its default value and return the previous value.
     *
     * @return string
     */
    public function reset(): string;

    /**
     * Submit the field with given value in context and
     * return the resolved value that you can use in your domain.
     *
     * @param string $value
     * @param array  $context
     * @return mixed
     * @throws FieldIsRequired
     * @throws InvalidFieldValue
     */
    public function submit(string $value, array $context);

    /**
     * Get the error message from last submit or null if there was no error.
     *
     * @return string|null
     */
    public function getError(): ?string;

}
