<?php

namespace Species\HtmlForm\Field;

use Species\HtmlForm\FormInputField;

/**
 * Implementation of standard input field.
 */
final class InputField extends Field implements FormInputField
{

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['label'] ?? null,
            $data['defaultValue'] ?? null,
            $data['required'] ?? null,
            $data['resolver'] ?? null,
            $data['handler'] ?? null
        );
    }



    /** @inheritdoc */
    protected function guardFieldValue(): void
    {
        // all values are fine.
    }

}
