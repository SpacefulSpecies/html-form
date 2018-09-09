<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\SimpleForm\Exception\ExpectingStringValue;
use Species\HtmlForm\SimpleForm\Exception\OptionsCannotBeEmpty;
use Species\HtmlForm\SimpleForm\Exception\ValueNotInOptions;

/**
 * Value with options trait.
 */
trait ValueWithOptionsTrait
{

    /** @var array */
    private $options = [];



    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }



    /**
     * @param iterable $options
     * @return string[]
     * @throws HtmlInvalidFieldValue
     */
    final protected function validateOptions(iterable $options): array
    {
        $unique = [];
        foreach ($options as $option) {
            if (!StringManipulation::canCastToString($option)) {
                throw new ExpectingStringValue();
            }
            $unique["$option"] = null;
        }
        $unique = array_keys($unique);

        if (count($unique) === 0) {
            throw new OptionsCannotBeEmpty();
        }

        return $unique;
    }



    /**
     * @param string $value
     * @return string
     * @throws HtmlInvalidFieldValue
     */
    final protected function validateOptionValue(string $value): string
    {
        if (in_array($value, $this->options, true)) {
            return $value;
        }

        if (StringManipulation::trim($value) === '') {
            return '';
        }

        throw new ValueNotInOptions();
    }

}
