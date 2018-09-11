<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidTimeValue;

/**
 * Time field.
 */
final class TimeField extends InputField implements HtmlInputField
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

        parent::__construct('time', $name, $value, $required, $handler);
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

        if (!preg_match('/^([0-9]{2}):([0-9]{2})$/D', $value, $matches)) {
            throw new InvalidTimeValue();
        }

        $hour = (int)$matches[1];
        $minute = (int)$matches[2];

        if ($hour > 23 || $minute > 59) {
            throw new InvalidTimeValue();
        }

        return $value;
    }

}
