<?php

namespace Species\HtmlForm\SimpleForm\Field;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Field\HtmlSubmitField;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleCheckNode;

/**
 * Submit field.
 */
final class SubmitField extends SimpleCheckNode implements HtmlSubmitField
{

    /**
     * @param string        $name
     * @param string        $value
     * @param callable|null $handler callable(bool $value, array $context): mixed
     * @throws HtmlInvalidFieldName
     */
    public function __construct(string $name, string $value, ?callable $handler)
    {
        if ($value === '') {
            $value = 'Submit Query';
        }

        parent::__construct($name, false, $value, false, function (string $value, array $context) use ($handler) {

            $value = ($value !== '');

            return $handler ? $handler($value, $context) : $value;
        });
    }

}
