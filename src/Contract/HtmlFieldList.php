<?php

namespace Species\HtmlForm\Contract;

use Species\HtmlForm\Exception\FieldIsRequired;
use Species\HtmlForm\Exception\InvalidFieldValue;

/**
 * Html field list interface.
 *
 * eg: <input name="hobbies[]">
 */
interface HtmlFieldList extends HtmlFieldName
{

    /**
     * Get the values as an indexed array of strings.
     *
     * @return string[]
     */
    public function getValues(): array;

    /**
     * Get the default values of the field list.
     *
     * @return string[]
     */
    public function getDefaultValues(): array;



    /**
     * Reset the field list to its default values and return the previous values.
     *
     * @return string[]
     */
    public function reset(): array;

    /**
     * Submit the field list with given values in context and
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
     * Get the error messages from last submit.
     *
     * @return string[]|null[]
     */
    public function getErrors(): array;

}
