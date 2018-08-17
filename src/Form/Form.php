<?php

namespace Species\HtmlForm\Form;

use Psr\Http\Message\ServerRequestInterface;
use Species\HtmlForm\Exception\InvalidForm;
use Species\HtmlForm\Field\Fields;
use Species\HtmlForm\HtmlForm;
use Species\HtmlForm\FormFields;

/**
 * Implementation of a html form.
 */
final class Form implements HtmlForm
{

    /** @var callable */
    private $handler;

    /** @var FormFields */
    private $fields;

    /** @var array */
    private $errors = [];



    /**
     * @param callable|null         $handler = null
     * @param FormFields|array|null $fields  = null
     */
    public function __construct(?callable $handler = null, $fields = null)
    {
        if (!$fields instanceof FormFields) {
            $fields = Fields::fromArray(is_array($fields) ? $fields : []);
        }

        $this->handler = $handler ?: function (): void {
        };
        $this->fields = $fields;
    }



    /** @inheritdoc */
    public function getFields(): FormFields
    {
        return $this->fields;
    }

    /** @inheritdoc */
    public function getErrors(): array
    {
        return $this->errors;
    }



    /** @inheritdoc */
    public function submit(ServerRequestInterface $request): bool
    {
        $values = $request->getParsedBody();
        if (!is_array($values)) {
            $this->errors['form'] = 'CannotParseRequestBody';

            return false;
        }

        return $this->submitArray($values);
    }

    /** @inheritdoc */
    public function submitArray(array $values): bool
    {
        $this->errors = [];
        $values = $this->resolveFieldNames($values);

        $resolved = [];
        foreach ($this->fields as $field) {
            $name = $field->getName();
            try {
                $value = $values[$name] ?? $field->getValue();
                $resolved[$name] = $field->submit($value);
            } catch (\Throwable $e) {
                $this->errors[$name] = $field->getError();
            }
        }

        if (empty($this->errors)) {
            foreach ($this->fields as $field) {
                $name = $field->getName();
                try {
                    $field->handle($this->fields);
                } catch (\Throwable $e) {
                    $this->errors[$name] = $field->getError();
                }
            }
        }

        if (empty($this->errors)) {
            try {
                $handler = $this->handler;
                $handler($resolved);
            } catch (\Throwable $e) {
                $e = InvalidForm::withReason($e);
                $this->errors['form'] = $e->getMessage();
            }
        }

        return empty($this->errors);
    }



    /**
     * @param array  $array
     * @param string $parentName
     * @return array
     */
    private function resolveFieldNames(array $array, $parentName = ''): array
    {
        $resolved = [];
        foreach ($array as $key => $value) {
            $name = $parentName ? $parentName . "[$key]" : $key;
            if (is_iterable($value)) {
                $resolved += $this->resolveFieldNames($value, $name);
            } else {
                $resolved[$name] = $value;
            }
        }

        return $resolved;
    }

}
