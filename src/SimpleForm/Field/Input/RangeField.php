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

    /** @var float */
    private $min;

    /** @var float */
    private $max;

    /** @var float */
    private $step;



    /**
     * @param string        $name
     * @param float|null      $value
     * @param callable|null $handler callable(float $value, array $context): mixed
     * @param float           $min
     * @param float           $max
     * @param float           $step    = 1
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(string $name, ?float $value, ?callable $handler, float $min, float $max, float $step = 1)
    {
        $value = (string)$this->validateFieldValue((string)$value ?? '');

        parent::__construct('range', $name, $value, true, $handler);

        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
    }



    /** @inheritdoc */
    public function getMin(): float
    {
        return $this->min;
    }

    /** @inheritdoc */
    public function getMax(): float
    {
        return $this->max;
    }

    /** @inheritdoc */
    public function getStep(): float
    {
        return $this->step;
    }



    /**
     * @param string $value
     * @return float|null
     * @throws HtmlInvalidFieldValue
     */
    protected function validateFieldValue(string $value): ?float
    {
        $value = StringManipulation::trim($value);

        if ($value === '') {
            return null;
        }

        if (!is_numeric($value)) {
            throw new InvalidNumberValue();
        }

        $value = (float)$value;

        if ($value < $this->min || $value > $this->max) {
            throw new NumberValueOutOfRange();
        }

        if ($value % $this->step !== 0) {
            throw new NumberValueOutOfStep();
        }

        return $value;
    }

}
