<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when no form field/list/group is found with given name.
 */
final class FieldNotFound extends \DomainException implements HtmlFormException
{

}
