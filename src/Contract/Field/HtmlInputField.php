<?php

namespace Species\HtmlForm\Contract\Field;

use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Value\StringValue;

/**
 * Html input field interface.
 */
interface HtmlInputField extends LeafNode, StringValue
{

    /**
     * @const TYPES
     */
    const TYPES = [
        'text', 'search', 'hidden', 'password',
        'tel', 'email', 'url', 'color',
        'number', 'range',
        'time', 'week', 'month', 'date', 'datetime-local',
    ];



    /**
     * @return string
     */
    public function getType(): string;

}
