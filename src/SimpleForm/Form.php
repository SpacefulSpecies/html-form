<?php

namespace Species\HtmlForm\SimpleForm;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\HtmlForm;
use Species\HtmlForm\Contract\Node\NodeCollection;
use Species\HtmlForm\SimpleForm\Abstraction\DelegateValueTrait;

/**
 * Form.
 */
final class Form implements HtmlForm
{

    use DelegateValueTrait;



    /** @var NodeCollection */
    private $fields;

    /** @var callable */
    private $handler;



    /**
     * @param NodeCollection $fields
     * @param callable       $handler callable(array $values, array $context): void
     */
    public function __construct(NodeCollection $fields, callable $handler)
    {
        $this->fields = $fields;
        $this->handler = $handler;
    }



    /** @inheritdoc */
    public function getFields(): NodeCollection
    {
        return $this->fields;
    }



    /** @inheritdoc */
    public function getValues(): array
    {
        return $this->getValuesFrom($this->fields);
    }

    /** @inheritdoc */
    public function getDefaultValues(): array
    {
        return $this->getDefaultValuesFrom($this->fields);
    }

    /** @inheritdoc */
    public function isRequired(): bool
    {
        return $this->isRequiredFor($this->fields);
    }



    /** @inheritdoc */
    public function getError(): ?string
    {
        return $this->getDelegateError();
    }

    /** @inheritdoc */
    public function getErrors(): array
    {
        return $this->getErrorsFrom($this->fields);
    }



    /** @inheritdoc */
    public function submit(array $values, array $context = []): bool
    {
        try {
            $this->submitTo($this->fields, $this->handler, $values, $context);
        } catch (HtmlInvalidFieldValue $e) {
            return false;
        }

        return true;
    }

    /** @inheritdoc */
    public function reset(): void
    {
        $this->resetOn($this->fields);
    }

}
