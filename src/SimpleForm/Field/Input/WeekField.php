<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidWeekValue;

/**
 * Week field.
 */
final class WeekField extends InputField implements HtmlInputField
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
            $value = $value->format('Y-\WW');
        } else {
            $value = '';
        }

        parent::__construct('week', $name, $value, $required, $handler);
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

        // eg: "2018-W12"
        if (!preg_match('/^([0-9]{4})-W([0-9]{2})$/D', $value, $matches)) {
            throw new InvalidWeekValue();
        }

        try {
            $value = (new \DateTimeImmutable())->setISODate($matches[1], $matches[2]);
        } catch (\Throwable $e) {
            throw new InvalidWeekValue();
        }

        if (!$value instanceof \DateTimeImmutable) {
            throw new InvalidWeekValue();
        }

        $value = $value->setTime(0, 0, 0, 0);

        return $value;
    }

}
