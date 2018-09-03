<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when trying to modify a html field collection.
 */
final class FieldCollectionIsReadOnly extends \DomainException implements HtmlFormException
{

}
