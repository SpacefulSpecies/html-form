<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when adding a form field with a name that already exists.
 */
final class FieldNameAlreadyExists extends \DomainException implements HtmlFormException
{

}
