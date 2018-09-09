<?php

namespace Species\HtmlForm\SimpleForm\Field\Input;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Field\HtmlNumberInputField;
use Species\HtmlForm\SimpleForm\Abstraction\InputField;
use Species\HtmlForm\SimpleForm\Abstraction\StringManipulation;
use Species\HtmlForm\SimpleForm\Exception\InvalidNumberValue;
use Species\HtmlForm\SimpleForm\Exception\NumberValueOutOfRange;
use Species\HtmlForm\SimpleForm\Exception\NumberValueOutOfStep;

/**
 * Range field.
 */
final class RangeField extends InputField implements HtmlNumberInputField
{

    /** @var int */
    private $min;

    /** @var int */
    private $max;

    /** @var int */
    private $step;



    /**
     * @param string        $name
     * @param int|null      $value
     * @param callable|null $handler callable(int $value, array $context): mixed
     * @param int           $min
     * @param int           $max
     * @param int           $step    = 1
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(string $name, ?int $value, ?callable $handler, int $min, int $max, int $step = 1)
    {
        $value = (string)$this->validateFieldValue($value);

        parent::__construct('range', $name, $value, true, $handler);

        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
    }



    /** @inheritdoc */
    public function getMin(): int
    {
        return $this->min;
    }

    /** @inheritdoc */
    public function getMax(): int
    {
        return $this->max;
    }

    /** @inheritdoc */
    public function getStep(): int
    {
        return $this->step;
    }



    /**
     * @param string $value
     * @return int|null
     * @throws HtmlInvalidFieldValue
     */
    protected function validateFieldValue(string $value): ?int
    {
        $value = StringManipulation::trim($value);

        if ($value === '') {
            return null;
        }

        if (!is_numeric($value)) {
            throw new InvalidNumberValue();
        }

        $value = (int)$value;

        if ($value < $this->min || $value > $this->max) {
            throw new NumberValueOutOfRange();
        }

        if ($value % $this->step !== 0) {
            throw new NumberValueOutOfStep();
        }

        return $value;
    }

}
