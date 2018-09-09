<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidUrlValue;

/**
 * Url field.
 */
final class UrlField extends InputField implements HtmlInputField
{

    /**
     * @param string        $name
     * @param string        $value
     * @param bool          $required
     * @param callable|null $handler callable(?string $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(string $name, string $value, bool $required, ?callable $handler)
    {
        $value = (string)$this->validateFieldValue($value);

        parent::__construct('url', $name, $value, $required, $handler);
    }



    /**
     * @param string $value
     * @return string|null
     * @throws HtmlInvalidFieldValue
     */
    protected function validateFieldValue(string $value): ?string
    {
        $value = StringManipulation::trim($value);

        if ($value === '') {
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlValue();
        }

        return $value;
    }

}
