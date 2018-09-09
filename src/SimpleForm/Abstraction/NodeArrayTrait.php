<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Exception\HtmlNodeCollectionReadOnly;
use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\SimpleForm\Exception\FieldNotFound;
use Species\HtmlForm\SimpleForm\Exception\NodeCollectionReadOnly;

/**
 * Node array trait.
 */
trait NodeArrayTrait
{

    /** @var Node[] */
    private $nodes = [];



    /**
     * @return Node[]|\Generator
     */
    final public function getIterator(): \Generator
    {
        yield from $this->nodes;
    }



    /**
     * @return int
     */
    final public function count(): int
    {
        return count($this->nodes);
    }



    /**
     * @param string $offset
     * @return bool
     */
    final public function offsetExists($offset): bool
    {
        return isset($this->nodes[$offset]);
    }

    /**
     * @param string $offset
     * @return Node
     */
    final public function offsetGet($offset): Node
    {
        if (!isset($this->nodes[$offset])) {
            throw new FieldNotFound();
        }

        return $this->nodes[$offset];
    }

    /**
     * @throws HtmlNodeCollectionReadOnly
     */
    final public function offsetSet(): void
    {
        throw new NodeCollectionReadOnly();
    }

    /**
     * @throws HtmlNodeCollectionReadOnly
     */
    final public function offsetUnset(): void
    {
        throw new NodeCollectionReadOnly();
    }

}
