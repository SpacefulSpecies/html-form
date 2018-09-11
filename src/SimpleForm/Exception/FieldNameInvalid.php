<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;

/**
 * Invalid field name exception.
 */
final class FieldNameInvalid extends \DomainException implements HtmlInvalidFieldName
{

}
