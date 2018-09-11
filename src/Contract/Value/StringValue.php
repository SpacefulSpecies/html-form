<?php

namespace Species\HtmlForm\Contract\Value;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;

/**
 * String value interface.
 */
interface StringValue extends FormValue
{

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return string
     */
    public function getDefaultValue(): string;



    /**
     * @param string $value
     * @param array  $context = []
     * @return mixed
     * @throws HtmlInvalidFieldValue
     */
    public function submit(string $value, array $context = []);

}
