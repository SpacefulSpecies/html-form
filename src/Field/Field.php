<?php

namespace Species\HtmlForm\Field;

use Species\HtmlForm\Exception\FieldIsRequired;
use Species\HtmlForm\Exception\InvalidFieldName;
use Species\HtmlForm\FormField;

/**
 * Boilerplate for form field implementations.
 */
abstract class Field implements FormField
{

    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /** @var string */
    private $defaultValue;

    /** @var bool */
    private $required;

    /** @var callable|null */
    private $resolver;



    /**
     * @param string        $name
     * @param string        $defaultValue = null (default: '')
     * @param bool|null     $required     = null (default: false)
     * @param callable|null $resolver     = null
     */
    public function __construct(
        string $name,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?callable $resolver = null
    )
    {
        $name = trim($name);
        if ($name === '') {
            throw new InvalidFieldName();
        }

        $this->name = $name;
        $this->defaultValue = $defaultValue ?? '';
        $this->required = $required ?? false;
        $this->resolver = $resolver;

        $this->value = $defaultValue;
    }



    /** @inheritdoc */
    final public function getName(): string
    {
        return $this->name;
    }

    /** @inheritdoc */
    final public function getValue(): string
    {
        return $this->value;
    }

    /** @inheritdoc */
    final public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

    /** @inheritdoc */
    final public function isRequired(): bool
    {
        return $this->required;
    }



    /** @inheritdoc */
    final public function submit(string $value): void
    {
        $this->value = $value;
    }


    /** @inheritdoc */
    final public function reset(): string
    {
        $previous = $this->value;
        $this->value = $this->defaultValue;

        return $previous;
    }



    /** @inheritdoc */
    public function resolve()
    {
        if ($this->required && $this->value = '') {
            throw new FieldIsRequired();
        }
        $resolver = $this->resolver;

        return $resolver ? $resolver($this->value) : $this->value;
    }

}
