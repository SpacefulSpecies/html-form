<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;

/**
 * Search field.
 */
final class SearchField extends InputField implements HtmlInputField
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
        parent::__construct('search', $name, $value, $required, $handler);
    }

}
