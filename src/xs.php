<?php
declare(strict_types=1);

namespace stk2k\xstring;

use stk2k\string\format\StringFormatTrait;

final class xs
{
    use StringFormatTrait;

    /**
     * Unbox xString
     *
     * @param $str
     *
     * @return string|null
     */
    public static function unbox($str) : ?string
    {
        return $str instanceof xString ? $str->value() : $str;
    }

    /**
     * Unbox xString
     *
     * @param $str
     *
     * @return string|null
     */
    public static function toString($str) : ?string
    {
        if ($str instanceof xStringBuffer){
            return $str->toString()->value();
        }
        if ($str instanceof xString){
            return $str->value();
        }
         if ($str === true){
            return 'true';
        }
         if ($str === false){
            return 'false';
        }
         if (is_scalar($str)){
            return "$str";
        }
         if (is_object($str) && method_exists($str, '__toString')){
            return $str->__toString();
        }
        return null;
    }

    /**
     * Join array elements with a string
     *
     * @param string $separator
     * @param array $values
     * @param string $encoding
     *
     * @return xString
     */
    public static function join(string $separator, array $values, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        $str = implode($separator, $values);
        return new xString($str, $encoding);
    }

    /**
     * Make new string object
     *
     * @param string $str
     * @param string $encoding
     *
     * @return xString
     */
    public static function newString(string $str, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return new xString($str, $encoding);
    }

    /**
     * Get length
     *
     * @param string $str
     * @param string $encoding
     *
     * @return int
     */
    public static function length(string $str, string $encoding = xString::DEFAULT_ENCODING) : int
    {
        return self::newString($str, $encoding)->length();
    }

    /**
     * Check if the two strings are same
     *
     * @param string $a
     * @param string $b
     * @param string $encoding
     *
     * @return bool
     */
    public static function equals(string $a, string $b, string $encoding = xString::DEFAULT_ENCODING) : bool
    {
        return self::newString($a, $encoding)->equalsTo(self::newString($b, $encoding));
    }

    /**
     * Compare the two strings
     *
     * @param string $a
     * @param string $b
     * @param string $encoding
     *
     * @return int
     */
    public static function compare(string $a, string $b, string $encoding = xString::DEFAULT_ENCODING) : int
    {
        return self::newString($a, $encoding)->compareTo(self::newString($b, $encoding));
    }

    /**
     * Seach string index
     *
     * @param string $subject
     * @param string $search
     * @param string $encoding
     *
     * @return int
     */
    public static function indexOf(string $subject, string $search, string $encoding = xString::DEFAULT_ENCODING) : int
    {
        return self::newString($subject, $encoding)->indexOf($search);
    }

    /**
     * Check if the string contains specified string
     *
     * @param string $subject
     * @param string $search
     * @param string $encoding
     *
     * @return bool
     */
    public static function contains(string $subject, string $search, string $encoding = xString::DEFAULT_ENCODING) : bool
    {
        return self::newString($subject, $encoding)->contains($search);
    }

    /**
     * Check if the string starts with specified string
     *
     * @param string $subject
     * @param string $search
     * @param string $encoding
     *
     * @return bool
     */
    public static function startsWith(string $subject, string $search, string $encoding = xString::DEFAULT_ENCODING) : bool
    {
        return self::newString($subject, $encoding)->startsWith($search);
    }

    /**
     * Check if the string starts with specified string
     *
     * @param string $subject
     * @param string $search
     * @param string $encoding
     *
     * @return bool
     */
    public static function endsWith(string $subject, string $search, string $encoding = xString::DEFAULT_ENCODING) : bool
    {
        return self::newString($subject, $encoding)->endsWith($search);
    }

    /**
     * Get part of string
     *
     * @param string $subject
     * @param int $start
     * @param int|null $length
     * @param string $encoding
     *
     * @return xString
     */
    public static function substring(string $subject, int $start, int $length = null, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->substring($start, $length);
    }

    /**
     * Remove a part of string
     *
     * @param string $subject
     * @param int $start
     * @param int|null $length
     * @param string $encoding
     *
     * @return xString
     */
    public static function remove(string $subject, int $start, int $length = null, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->remove($start, $length);
    }

    /**
     * Remove a part of string
     *
     * @param string $subject
     * @param int $start
     * @param string $insert
     * @param string $encoding
     *
     * @return xString
     */
    public static function insert(string $subject, int $start, string $insert, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->insert($start, $insert);
    }

    /**
     * Get lower case string
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return xString
     */
    public static function toLower(string $subject, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->toLower();
    }

    /**
     * Get upper case string
     *
     * @param string $subject
     * @param string $encoding
     *
     * @return xString
     */
    public static function toUpper(string $subject, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->toUpper();
    }

    /**
     * Strip whitespace
     *
     * @param string $subject
     * @param string|null $characters
     * @param string $encoding
     *
     * @return xString
     */
    public static function trim(string $subject, string $characters = null, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->trim($characters);
    }

    /**
     * Strip whitespace from start
     *
     * @param string $subject
     * @param string|null $characters
     * @param string $encoding
     *
     * @return xString
     */
    public static function trimStart(string $subject, string $characters = null, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->trimStart($characters);
    }

    /**
     * Strip whitespace from end
     *
     * @param string $subject
     * @param string|null $characters
     * @param string $encoding
     *
     * @return xString
     */
    public static function trimEnd(string $subject, string $characters = null, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->trimEnd($characters);
    }

    /**
     * Replace string
     *
     * @param string $subject
     * @param string $search
     * @param string $replacement
     * @param string $encoding
     *
     * @return xString
     */
    public static function replace(string $subject, string $search, string $replacement, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->replace($search, $replacement);
    }

    /**
     * Replace string by regular expression
     *
     * @param string $subject
     * @param string $pattern
     * @param string $replacement
     * @param string $encoding
     *
     * @return xString
     */
    public static function replaceRegEx(string $subject, string $pattern, string $replacement, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->replaceRegEx($pattern, $replacement);
    }

    /**
     * Split string into string array by seperator
     *
     * @param string $subject
     * @param string $separator
     * @param string $encoding
     *
     * @return xStringArray
     */
    public static function split(string $subject, string $separator, string $encoding = xString::DEFAULT_ENCODING) : xStringArray
    {
        return self::newString($subject, $encoding)->split($separator);
    }

    /**
     * Split string into string array by seperator
     *
     * @param string $subject
     * @param string $encoding
     * @param ... $targets
     *
     * @return xString
     */
    public static function concat(string $subject, string $encoding, ... $targets) : xString
    {
        $str = self::newString($subject, $encoding);
        foreach($targets as $item){
            $str->set($str->value() . self::toString($item));
        }
        return $str;
    }

    /**
     * Processes each characters
     *
     * @param string $subject
     * @param callable $cb
     * @param string $encoding
     *
     * @return xString
     */
    public static function each(string $subject, callable $cb, string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return self::newString($subject, $encoding)->each($cb);
    }
}