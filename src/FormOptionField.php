<?php

namespace Species\HtmlForm;

use Species\HtmlForm\Exception\FieldValueNotInOptions;

/**
 * Form option field interface (like <select> and <input type="radio">).
 */
interface FormOptionField extends FormField
{

    /**
     * The options in the form of [$value => $label].
     *
     * @return string[]
     */
    public function getOptions(): array;



    /**
     * @inheritdoc
     * @throws FieldValueNotInOptions
     */
    public function resolve();

}
