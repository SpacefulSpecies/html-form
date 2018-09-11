<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;

/**
 * Password field.
 */
final class PasswordField extends InputField implements HtmlInputField
{

    /**
     * @param string        $name
     * @param bool          $required
     * @param callable|null $handler callable(string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, bool $required, ?callable $handler)
    {
        parent::__construct('password', $name, '', $required, $handler);
    }

}
