<?php

namespace Species\HtmlForm\Contract\Node;

use Species\HtmlForm\Contract\Exception\HtmlFieldNotFound;
use Species\HtmlForm\Contract\Exception\HtmlNodeCollectionReadOnly;

/**
 * Html form node collection interface.
 * Overrides return types and docs of \IteratorAggregate, \Countable and \ArrayAccess for IDE support.
 */
interface NodeCollection extends \IteratorAggregate, \Countable, \ArrayAccess
{

    /**
     * @inheritdoc
     * @yield string|int => Node
     * @return Node[]|\Generator
     */
    public function getIterator(): \Generator;



    /** @inheritdoc */
    public function count(): int;



    /**
     * @inheritdoc
     * @param string|int $offset
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * @inheritdoc
     * @param string|int $offset
     * @return Node
     * @throws HtmlFieldNotFound
     */
    public function offsetGet($offset): Node;

    /**
     * @inheritdoc
     * @throws HtmlNodeCollectionReadOnly
     */
    public function offsetSet($offset, $value): void;

    /**
     * @inheritdoc
     * @throws HtmlNodeCollectionReadOnly
     */
    public function offsetUnset($offset): void;

}
