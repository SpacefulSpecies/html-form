<?php

namespace Species\HtmlForm\SimpleForm;

use Psr\Http\Message\ServerRequestInterface;
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

    /** @var string */
    private $method;



    /**
     * @param NodeCollection $fields
     * @param callable       $handler callable(array $values, array $context): void
     * @param string         $method  = 'post'
     */
    public function __construct(NodeCollection $fields, callable $handler, string $method = 'post')
    {
        $this->fields = $fields;
        $this->handler = $handler;
        $this->method = strtolower($method) === self::GET ? self::GET : self::POST;
    }



    /** @inheritdoc */
    public function getFields(): NodeCollection
    {
        return $this->fields;
    }

    /** @inheritdoc */
    public function getMethod(): string
    {
        return $this->method;
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



    /**
     * @param array $values
     * @param array $context
     * @return bool
     */
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
    public function submitRequest(ServerRequestInterface $request, array $context = []): bool
    {
        if (strtolower($request->getMethod()) !== $this->getMethod()) {
            return false;
        }

        return $this->submit($request->getParsedBody(), $context);
    }

    /** @inheritdoc */
    public function reset(): void
    {
        $this->resetOn($this->fields);
    }

}
