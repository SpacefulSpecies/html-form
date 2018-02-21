<?php

namespace Species\HtmlForm\Field;

/**
 * Implementation of standard input field
 */
final class InputField extends Field
{

    /**
     * @param array $data
     * @return self
     */
    public function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['label'] ?? '',
            $data['defaultValue'] ?? null,
            $data['required'] ?? null,
            $data['resolver'] ?? null
        );
    }

}
