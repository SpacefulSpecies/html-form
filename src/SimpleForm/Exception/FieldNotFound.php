<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlFieldNotFound;

/**
 * Field not found exception.
 */
final class FieldNotFound extends \DomainException implements HtmlFieldNotFound
{

}
