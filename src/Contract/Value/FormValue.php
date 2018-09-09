<?php

namespace Species\HtmlForm\Contract\Value;

/**
 * Form value interface
 */
interface FormValue
{

    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @return string|null
     */
    public function getError(): ?string;



    /**
     * @return void
     */
    public function reset(): void;

}
