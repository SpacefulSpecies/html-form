<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidDateValue;

/**
 * Date field.
 */
final class DateField extends InputField implements HtmlInputField
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
            $value = $value->format('Y-m-d');
        } else {
            $value = '';
        }

        parent::__construct('date', $name, $value, $required, $handler);
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
            $value = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        } catch (\Throwable $e) {
            throw new InvalidDateValue();
        }

        if (!$value instanceof \DateTimeImmutable) {
            throw new InvalidDateValue();
        }

        $value = $value->setTime(0, 0, 0, 0);

        return $value;
    }

}
