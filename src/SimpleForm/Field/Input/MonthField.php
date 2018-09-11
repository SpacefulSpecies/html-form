<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidMonthValue;

/**
 * Month field.
 */
final class MonthField extends InputField implements HtmlInputField
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
            $value = $value->format('Y-m');
        } else {
            $value = '';
        }

        parent::__construct('month', $name, $value, $required, $handler);
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

        $value = str_replace('/', '-', $value);

        // "m-Y" to "Y-m"
        $value = preg_replace_callback('/([0-9]{2})-([0-9]{4})/S', function (array $matches) {
            return sprintf('%s-%s', $matches[2], $matches[1]);
        }, $value);

        try {
            $value = \DateTimeImmutable::createFromFormat('Y-m-d', "$value-01");
        } catch (\Throwable $e) {
            throw new InvalidMonthValue();
        }

        if (!$value instanceof \DateTimeImmutable) {
            throw new InvalidMonthValue();
        }

        $value = $value->setTime(0, 0, 0, 0);

        return $value;
    }

}
