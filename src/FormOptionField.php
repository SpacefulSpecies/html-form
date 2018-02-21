<?php

namespace Species\HtmlForm;

use Species\HtmlForm\Exception\InvalidFieldOptions;

/**
 * Form option field interface (like <select> and <input type="radio">).
 *
 * @throws InvalidFieldOptions
 */
interface FormOptionField extends FormField
{

    /**
     * The options in the form of [$value => $label].
     *
     * @return string[]
     */
    public function getOptions(): array;

}
