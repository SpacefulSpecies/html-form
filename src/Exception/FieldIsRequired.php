<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when trying to resolve a required field without a value.
 */
final class FieldIsRequired extends \DomainException implements HtmlFormException
{

}
