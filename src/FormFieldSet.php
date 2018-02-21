<?php

namespace Species\HtmlForm;

use Species\HtmlForm\Exception\FieldValueNotInSet;

/**
 * Form field set interface (like <select> and <input type="radio">).
 */
interface FormFieldSet extends FormField
{

    /**
     * The values in the set as array in the form of [$value => $label].
     *
     * @return string[]
     */
    public function getValues(): array;



    /**
     * @inheritdoc
     * @throws FieldValueNotInSet
     */
    public function resolve();

}
