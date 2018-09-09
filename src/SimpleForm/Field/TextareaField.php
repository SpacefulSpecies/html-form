<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlTextareaField;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleStringNode;

/**
 * Textarea field.
 */
final class TextareaField extends SimpleStringNode implements HtmlTextareaField
{

    /**
     * @param string        $name
     * @param string        $value
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, string $value, bool $required, ?callable $handler)
    {
        parent::__construct($name, $value, $required, $handler);
    }

}
