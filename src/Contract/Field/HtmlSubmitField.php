<?php

namespace Species\HtmlForm\Contract\Field;

use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Value\CheckedStringValue;

/**
 * Html submit field interface.
 */
interface HtmlSubmitField extends LeafNode, CheckedStringValue
{

}
