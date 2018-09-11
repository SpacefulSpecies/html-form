<?php

namespace Species\HtmlForm\Contract\Field;

use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Value\StringValue;

/**
 * Html select field interface.
 */
interface HtmlSelectField extends LeafNode, StringValue
{

    /**
     * @return string[]
     */
    public function getOptions(): array;

}
