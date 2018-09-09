<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlFormException;

/**
 * Invalid input field type exception.
 */
final class UnknownInputFieldType extends \DomainException implements HtmlFormException
{

}
