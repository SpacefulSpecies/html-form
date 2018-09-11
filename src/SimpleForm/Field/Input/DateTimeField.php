<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidDateTimeValue;

/**
 * Date-time field.
 */
final class DateTimeField extends InputField implements HtmlInputField
{

    /**
     * @param string                  $name
     * @param \DateTimeInterface|null $value
     * @param bool                    $required
     * @param callable|null           $handler callable(?\DateTimeImmutable $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, ?\DateTimeInterface $value, bool $required, ?callable $handler)
    {
        if ($value instanceof \DateTimeInterface) {
            $value = $value->format('Y-m-d\TH:i');
        } else {
            $value = '';
        }

        parent::__construct('datetime-local', $name, $value, $required, $handler);
    }



    /**
     * @param string $value
     * @return \DateTimeImmutable|null
     * @throws HtmlInvalidFieldValue
     */
    protected function validateFieldValue(string $value): ?\DateTimeImmutable
    {
        $value = StringManipulation::trim($value);

        if ($value === '') {
            return null;
        }

        $value = StringManipulation::normalizeDateString($value);

        try {
            $value = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $value);
        } catch (\Throwable $e) {
            throw new InvalidDateTimeValue();
        }

        if (!$value instanceof \DateTimeImmutable) {
            throw new InvalidDateTimeValue();
        }

        return $value;
    }

}
