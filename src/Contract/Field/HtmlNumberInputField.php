<?php

namespace Species\HtmlForm\Contract\Field;

/**
 * Html number input field interface.
 */
interface HtmlNumberInputField extends HtmlInputField
{

    /**
     * @return float|null
     */
    public function getMin(): ?float;

    /**
     * @return float|null
     */
    public function getMax(): ?float;

    /**
     * @return float|null
     */
    public function getStep(): ?float;

}
