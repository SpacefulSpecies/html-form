<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when trying to resolve an invalid field value.
 */
final class InvalidFieldValue extends \InvalidArgumentException implements HtmlFormException
{

    /**
     * @param \Throwable  $previous
     * @param string|null $message = null
     */
    public function __construct(\Throwable $previous, ?string $message = null)
    {
        $message = $message ?? $this->getClassName($previous);

        parent::__construct($message, 0, $previous);
    }



    /**
     * @param \Throwable $e
     * @return string
     */
    private function getClassName(\Throwable $e): string
    {
        return array_pop(explode('\\', get_class($e)));
    }

}
