<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlRadioField;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleCheckNode;

/**
 * Radio field.
 */
final class RadioField extends SimpleCheckNode implements HtmlRadioField
{

    /**
     * @param string        $name
     * @param bool          $checked
     * @param string        $value
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, bool $checked, string $value, bool $required, ?callable $handler)
    {
        parent::__construct($name, $checked, $value, $required, $handler);
    }

}
