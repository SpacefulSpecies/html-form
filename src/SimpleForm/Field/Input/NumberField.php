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
 * Number field.
 */
final class NumberField extends InputField implements HtmlNumberInputField
{

    /** @var float|null */
    private $min;

    /** @var float|null */
    private $max;

    /** @var float|null */
    private $step;



    /**
     * @param string        $name
     * @param float|null      $value
     * @param bool          $required
     * @param callable|null $handler callable(?float $value, array $context): mixed
     * @param float|null      $min     = null
     * @param float|null      $max     = null
     * @param float|null      $step    = null
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(
        string $name,
        ?float $value,
        bool $required,
        ?callable $handler,
        ?float $min = null,
        ?float $max = null,
        ?float $step = null
    )
    {
        $value = (string)$this->validateFieldValue((string)$value ?? '');

        parent::__construct('number', $name, $value, $required, $handler);

        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
    }



    /** @inheritdoc */
    public function getMin(): ?float
    {
        return $this->min;
    }

    /** @inheritdoc */
    public function getMax(): ?float
    {
        return $this->max;
    }

    /** @inheritdoc */
    public function getStep(): ?float
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

        if ($this->min !== null && $value < $this->min) {
            throw new NumberValueOutOfRange();
        }
        if ($this->max !== null && $value > $this->max) {
            throw new NumberValueOutOfRange();
        }
        if ($this->step !== null && $value % $this->step !== 0) {
            throw new NumberValueOutOfStep();
        }

        return $value;
    }

}
