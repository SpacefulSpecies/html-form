<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when trying to resolve an invalid field value.
 */
final class InvalidFieldValue extends \InvalidArgumentException implements HtmlFormException
{

    /**
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous)
    {
        parent::__construct('', 0, $previous);
    }

}
