<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\SimpleForm\Exception\UnknownInputFieldType;

/**
 * Abstract input field.
 */
abstract class InputField extends SimpleStringNode implements HtmlInputField
{

    /** @var string */
    private $type;



    /**
     * @param string        $type
     * @param string        $name
     * @param string        $value
     * @param bool          $required
     * @param callable|null $handler callable(mixed $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $type, string $name, string $value, bool $required, ?callable $handler)
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new UnknownInputFieldType();
        }

        parent::__construct($name, $value, $required, function (string $value, array $context) use ($handler) {

            $value = StringManipulation::replaceNewlinesWithSpaces($value);
            $value = $this->validateFieldValue($value);

            return $handler ? $handler($value, $context) : $value;
        });

        $this->type = $type;
    }



    /** @inheritdoc */
    final public function getType(): string
    {
        return $this->type;
    }



    /**
     * @param string $value
     * @return mixed
     */
    protected function validateFieldValue(string $value)
    {
        return $value;
    }

}
