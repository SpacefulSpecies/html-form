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

    /** @var int|null */
    private $min;

    /** @var int|null */
    private $max;

    /** @var int|null */
    private $step;



    /**
     * @param string        $name
     * @param int|null      $value
     * @param bool          $required
     * @param callable|null $handler callable(?int $value, array $context): mixed
     * @param int|null      $min     = null
     * @param int|null      $max     = null
     * @param int|null      $step    = null
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function __construct(
        string $name,
        ?int $value,
        bool $required,
        ?callable $handler,
        ?int $min = null,
        ?int $max = null,
        ?int $step = null
    )
    {
        $value = (string)$this->validateFieldValue($value);

        parent::__construct('number', $name, $value, $required, $handler);

        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
    }



    /** @inheritdoc */
    public function getMin(): ?int
    {
        return $this->min;
    }

    /** @inheritdoc */
    public function getMax(): ?int
    {
        return $this->max;
    }

    /** @inheritdoc */
    public function getStep(): ?int
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
