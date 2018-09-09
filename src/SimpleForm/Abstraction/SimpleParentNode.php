<?php

namespace Species\HtmlForm\Form;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\Contract\Node\ParentNode;
use Species\HtmlForm\SimpleForm\Abstraction\NodeArrayTrait;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleNode;

/**
 * Abstract simple parent node.
 */
abstract class SimpleParentNode extends SimpleNode implements ParentNode
{

    use NodeArrayTrait;



    /**
     * @param string          $name
     * @param Node[]|iterable $nodes
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, iterable $nodes)
    {
        parent::__construct($name);

        $this->setNodes($nodes);
    }



    /**
     * @param Node[]|iterable $nodes
     */
    final protected function setNodes(iterable $nodes): void
    {
        if ($nodes instanceof \Traversable) {
            $nodes = iterator_to_array($nodes, true);
        }

        array_walk($nodes, function (Node $node) {
            $node->setParent($this);
        });

        $this->nodes = $nodes;
    }

}
