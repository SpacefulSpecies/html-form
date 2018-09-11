<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

/**
 * String manipulation.
 */
final class StringManipulation
{

    /**
     * Static only.
     */
    private function __construct()
    {
    }



    /**
     * @param mixed $subject
     * @return bool
     */
    public static function canCastToString($subject): bool
    {
        return $subject === null
            || is_scalar($subject)
            || method_exists($subject, '__toString');
    }



    /**
     * @param string $string
     * @return string
     */
    public static function sanitize(string $string): string
    {
        $string = self::stripNullByte($string);
        $string = self::stripCarriageReturn($string);

        return $string;
    }



    /**
     * @param string $string
     * @return string
     */
    public static function trim(string $string): string
    {
        // space, tab, new line, carriage return, form feed, null byte, vertical tab
        return trim($string, " \t\n\r\f\0\x0B"); // default trim + form feed
    }

    /**
     * @param string $string
     * @return string
     */
    public static function stripNullByte(string $string): string
    {
        return str_replace("\0", '', $string);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function stripCarriageReturn(string $string): string
    {
        return str_replace("\r", '', $string);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function replaceNewlinesWithSpaces(string $string): string
    {
        // new line, form feed, vertical tab
        return str_replace(["\n", "\f", "\x0B"], ' ', $string);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function normalizeDateString(string $value): string
    {
        // "{date}T{time}" to "{date} {time}"
        $value = str_replace('T', ' ', $value);

        // "Y/m/d" to "Y-m-d"
        $value = str_replace('/', '-', $value);

        // "d-m-Y" to "Y-m-d"
        $value = preg_replace_callback('/([0-9]{2})-([0-9]{2})-([0-9]{4})/S', function (array $matches) {
            return sprintf('%s-%s-%s', $matches[3], $matches[2], $matches[1]);
        }, $value);

        return $value;
    }

}
