<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;

/**
 * Field is required exception.
 */
final class FieldIsRequired extends InvalidValue implements HtmlInvalidFieldValue
{

}
