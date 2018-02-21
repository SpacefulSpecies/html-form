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
    private $label;

    /** @var string */
    private $value;

    /** @var string */
    private $defaultValue;

    /** @var bool */
    private $required;

    /** @var callable|null */
    private $resolver;

    /** @var bool */
    private $error = false;



    /**
     * @param string        $name
     * @param string|null   $label        = ''
     * @param string|null   $defaultValue = ''
     * @param bool|null     $required     = false
     * @param callable|null $resolver     = null
     */
    public function __construct(
        string $name,
        ?string $label = '',
        ?string $defaultValue = '',
        ?bool $required = false,
        ?callable $resolver = null
    )
    {
        $this->name = trim($name);
        $this->label = $label ?? '';
        $this->defaultValue = $defaultValue ?? '';
        $this->required = $required ?? false;
        $this->resolver = $resolver;

        $this->value = $defaultValue;

        $this->guardFieldName();
    }



    /** @inheritdoc */
    final public function getName(): string
    {
        return $this->name;
    }

    /** @inheritdoc */
    final public function getLabel(): string
    {
        return $this->label;
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
    final public function reset(): string
    {
        $previous = $this->value;
        $this->value = $this->defaultValue;

        return $previous;
    }


    /** @inheritdoc */
    final public function submit(string $value)
    {
        $this->value = $value;
        $this->error = false;
        $resolver = $this->resolver;

        try {
            if ($this->required && $value = '') {
                throw new FieldIsRequired();
            }
            $this->guardFieldValue();

            return $resolver ? $resolver($value) : $value;
        } catch (\Throwable $e) {
            $this->error = true;
            throw $e;
        }
    }

    /** @inheritdoc */
    final public function hasError(): bool
    {
        return $this->error;
    }



    /**
     * @throws \Throwable
     */
    abstract protected function guardFieldValue(): void;

    /**
     * @throws InvalidFieldName
     */
    final protected function guardFieldName(): void
    {
        if ($this->name === '') {
            throw new InvalidFieldName();
        }
    }

}
