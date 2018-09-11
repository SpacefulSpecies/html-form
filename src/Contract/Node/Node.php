<?php

namespace Species\HtmlForm\Contract\Node;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;

/**
 * Html form node interface.
 *
 * @throws HtmlInvalidFieldName
 */
interface Node
{

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getShortName(): string;

    /**
     * @return ParentNode|null
     */
    public function getParent(): ?ParentNode;



    /**
     * @param ParentNode|null $parent
     */
    public function setParent(?ParentNode $parent): void;



    /**
     * @return Node
     */
    public function cloneNode(): Node;

}
