<?php

namespace Species\HtmlForm\Contract;

use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\Contract\Node\ParentNode;
use Species\HtmlForm\Contract\Value\ArrayValue;

/**
 * Html field list interface.
 */
interface HtmlFieldList extends ParentNode, ArrayValue
{

    /**
     * @return Node cloned
     */
    public function getPrototype(): Node;

}
