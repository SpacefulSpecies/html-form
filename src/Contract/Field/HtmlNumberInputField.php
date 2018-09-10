<?php

namespace Species\HtmlForm\Contract\Field;

/**
 * Html number input field interface.
 */
interface HtmlNumberInputField extends HtmlInputField
{

    /**
     * @return int|null
     */
    public function getMin(): ?int;

    /**
     * @return int|null
     */
    public function getMax(): ?int;

    /**
     * @return int|null
     */
    public function getStep(): ?int;

}
