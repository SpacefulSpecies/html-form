<?php

namespace Species\HtmlForm\Contract;

use Species\HtmlForm\Exception\InvalidFieldName;

/**
 * Form field name interface.
 *
 * @throws InvalidFieldName
 */
interface HtmlFieldName
{

    /**
     * Get the name of the form field/list/group.
     * eg: "email" or "hobbies[]" or "contact[address][street]"
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the short name of the form field/list/group.
     * eg: "email", "hobbies", "contact", "address", "street"
     *
     * @return string
     */
    public function getShortName(): string;

}
