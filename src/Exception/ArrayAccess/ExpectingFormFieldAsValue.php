<?php

namespace Species\HtmlForm\Exception\ArrayAccess;

use Species\HtmlForm\Exception\HtmlFormException;

/**
 * Exception thrown when the value set with \ArrayAccess is not a form field.
 */
final class ExpectingFormFieldAsValue extends \UnexpectedValueException implements HtmlFormException
{

}
