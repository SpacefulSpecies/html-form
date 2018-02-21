<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when the form field value is not from the set of values.
 */
final class FieldValueNotInSet extends \InvalidArgumentException implements HtmlFormException
{

}
