<?php

namespace Species\HtmlForm\Exception;

/**
 * Abstraction of a reasoned domain exception.
 */
abstract class ReasonedDomainException extends \DomainException implements HtmlFormException
{

    /**
     * @param \Throwable $reason
     * @return static
     */
    final public static function withReason(\Throwable $reason)
    {
        if ($reason instanceof static) {
            return $reason;
        }

        $message = $reason->getMessage() ?: self::getShortName($reason);

        return new static($message, $reason->getCode(), $reason);
    }



    /**
     * @param \Throwable $e
     * @return string
     */
    final private static function getShortName(\Throwable $e): string
    {
        $parts = explode('\\', get_class($e));

        return end($parts);
    }



    /** @inheritdoc */
    final public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $message = $message ?: self::getShortName($this);

        parent::__construct($message, $code, $previous);
    }

}
