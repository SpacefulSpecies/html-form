<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlCheckboxField;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleCheckNode;

/**
 * Checkbox field.
 */
final class CheckboxField extends SimpleCheckNode implements HtmlCheckboxField
{

    /**
     * @param string        $name
     * @param bool          $checked
     * @param bool          $required
     * @param callable|null $handler callable(bool $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, bool $checked, bool $required, ?callable $handler)
    {
        parent::__construct($name, $checked, 'on', $required, function (string $value, array $context) use ($handler) {

            $value = ($value !== '');

            return $handler ? $handler($value, $context) : $value;
        });
    }

}
