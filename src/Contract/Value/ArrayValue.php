<?php

namespace Species\HtmlForm\Contract\Value;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;

/**
 * Array value interface.
 */
interface ArrayValue extends FormValue
{

    /**
     * @return array
     */
    public function getValues(): array;

    /**
     * @return array
     */
    public function getDefaultValues(): array;



    /**
     * @return array
     */
    public function getErrors(): array;



    /**
     * @param array $values
     * @param array $context = []
     * @return mixed
     * @throws HtmlInvalidFieldValue
     */
    public function submit(array $values, array $context = []);

}
