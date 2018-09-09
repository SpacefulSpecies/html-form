<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;

/**
 * Options cannot be empty exception.
 */
final class OptionsCannotBeEmpty extends InvalidValue implements HtmlInvalidFieldValue
{

}
