<?php

namespace Species\HtmlForm\Exception\ArrayAccess;

use Species\HtmlForm\Exception\HtmlFormException;

/**
 * Exception thrown when the key used with \ArrayAccess is not the form field name.
 */
final class ExpectingFormFieldNameAsKey extends \OutOfBoundsException implements HtmlFormException
{

}
