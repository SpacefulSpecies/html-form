<?php

namespace Species\HtmlForm\Contract\Field;

use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Value\ArrayValue;

/**
 * Html select multiple field interface.
 */
interface HtmlSelectMultipleField extends LeafNode, ArrayValue
{

    /**
     * @return string[]
     */
    public function getOptions(): array;

}
