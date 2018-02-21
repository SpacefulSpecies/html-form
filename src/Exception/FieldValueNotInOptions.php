<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when the form field value is not from the set of options.
 */
final class FieldValueNotInOptions extends \InvalidArgumentException implements HtmlFormException
{

}
