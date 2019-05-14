<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use DeepCopy\DeepCopy;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlRadioFields;
use Species\HtmlForm\Contract\HtmlFieldList;
use Species\HtmlForm\Contract\Node\LeafNode;
use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\Contract\Node\ParentNode;
use Species\HtmlForm\Contract\Value\ArrayValue;
use Species\HtmlForm\SimpleForm\Exception\FieldNameInvalid;

/**
 * Abstract simple node.
 */
abstract class SimpleNode implements Node
{

    /** @var string */
    private $name;

    /** @var ParentNode|null */
    private $parent;



    /**
     * @param string $name
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name)
    {
        if (!preg_match('/^[a-z][a-z0-9\-_.:]*$/Di', $name)) {
            throw new FieldNameInvalid();
        }

        $this->name = $name;
    }



    /** @inheritdoc */
    final public function getName(): string
    {
        $name = $this->getFullName();

        if ($this instanceof ArrayValue && $this instanceof LeafNode) {
            $name .= '[]';
        }

        return $name;
    }

    /** @inheritdoc */
    final public function getShortName(): string
    {
        return $this->name;
    }

    /** @inheritdoc */
    final public function getParent(): ?ParentNode
    {
        return $this->parent;
    }



    /** @inheritdoc */
    final public function setParent(?ParentNode $parent): void
    {
        $this->parent = $parent;
    }



    /** @inheritdoc */
    final public function cloneNode(): Node
    {
        static $copier;
        if ($copier === null) {
            $copier = new DeepCopy();
        }

        $parent = $this->getParent();
        $this->setParent(null);

        $clone = $copier->copy($this);

        $this->setParent($parent);
        $clone->setParent($parent);

        return $clone;
    }



    /**
     * @return string
     */
    final private function getFullName(): string
    {
        if ($this->parent === null) {
            return $this->name;
        }

        if ($this->parent instanceof HtmlFieldList) {
            $index = null;
            foreach ($this->parent as $i => $node) {
                if ($node === $this) {
                    $index = $i;
                    break;
                }
            }

            return sprintf('%s[%s]', $this->parent->getName(), $index ?? $this->parent->count());
        }

        if ($this->parent instanceof HtmlRadioFields) {
            return $this->parent->getName();
        }

        return sprintf('%s[%s]', $this->parent->getName(), $this->name);
    }

}
