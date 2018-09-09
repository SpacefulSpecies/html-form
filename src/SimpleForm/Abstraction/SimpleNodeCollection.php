<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\Contract\Node\NodeCollection;

/**
 * Simple node collection.
 */
final class SimpleNodeCollection implements NodeCollection
{

    use NodeArrayTrait;



    /**
     * @param Node[]|iterable $nodes
     */
    public function __construct(iterable $nodes)
    {
        if ($nodes instanceof \Traversable) {
            $nodes = iterator_to_array($nodes, true);
        }

        array_walk($nodes, function (Node $node) {
        }, $nodes);

        $this->nodes = $nodes;
    }

}
