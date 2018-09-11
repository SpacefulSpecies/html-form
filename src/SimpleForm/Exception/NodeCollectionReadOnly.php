<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlNodeCollectionReadOnly;

/**
 * Node collection read only exception.
 */
final class NodeCollectionReadOnly extends \DomainException implements HtmlNodeCollectionReadOnly
{

}
