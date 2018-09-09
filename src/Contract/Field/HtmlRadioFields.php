<?php

namespace Species\HtmlForm\Contract\Field;

use Species\HtmlForm\Contract\Node\ParentNode;
use Species\HtmlForm\Contract\Value\StringValue;

/**
 * Html radio fields interface.
 */
interface HtmlRadioFields extends ParentNode, StringValue
{

    /**
     * @return string[]
     */
    public function getOptions(): array;

}
