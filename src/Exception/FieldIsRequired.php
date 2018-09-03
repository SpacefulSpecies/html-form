<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when submitting a required field without a value.
 */
final class FieldIsRequired extends \DomainException implements HtmlFormException
{

}
