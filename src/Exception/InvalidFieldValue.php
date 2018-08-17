<?php

namespace Species\HtmlForm\Exception;

/**
 * Exception thrown when submitting or handling an invalid field value.
 */
final class InvalidFieldValue extends \InvalidArgumentException implements HtmlFormException
{

    /**
     * @param \Throwable $reason
     * @return self
     */
    public static function withReason(\Throwable $reason): self
    {
        if ($reason instanceof self) {
            return $reason;
        }

        $message = $reason->getMessage() ?: self::getClassName($reason);

        return new self($message, 0, $reason);
    }



    /**
     * @param \Throwable $e
     * @return string
     */
    private static function getClassName(\Throwable $e): string
    {
        $parts = explode('\\', get_class($e));

        return array_pop($parts);
    }

}
