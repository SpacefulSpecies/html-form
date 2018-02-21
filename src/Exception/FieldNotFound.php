<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when no form field is found with given name.
 */
final class FieldNotFound extends \DomainException implements HtmlFormException
{

}
