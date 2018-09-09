<?php

namespace Species\HtmlForm\Contract;

use Species\HtmlForm\Contract\Node\NodeCollection;
use Species\HtmlForm\Contract\Value\ArrayValue;

/**
 * Html form interface.
 */
interface HtmlForm extends ArrayValue
{

    const POST = 'post';
    const GET = 'get';



    /**
     * @return NodeCollection
     */
    public function getFields(): NodeCollection;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param array $values
     * @param array $context = []
     * @return mixed
     */
    public function submit(array $values, array $context = []): bool;

}
