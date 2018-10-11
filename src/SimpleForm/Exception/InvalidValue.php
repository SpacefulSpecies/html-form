<?php

namespace Species\HtmlForm\SimpleForm\Exception;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;

/**
 * Invalid field value exception.
 */
class InvalidValue extends \DomainException implements HtmlInvalidFieldValue
{

    /**
     * @param \Throwable $reason
     * @return InvalidValue
     */
    final public static function withReason(\Throwable $reason): InvalidValue
    {
        if ($reason instanceof InvalidValue) {
            return $reason;
        }

        $message = $reason->getMessage() ?: self::getShortName($reason);
        $code = is_int($reason->getCode()) ? $reason->getCode() : 0;

        return new self($message, $code, $reason);
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
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $message = $message ?: self::getShortName($this);

        parent::__construct($message, $code, $previous);
    }

}
