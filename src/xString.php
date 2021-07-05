<?php
declare(strict_types=1);

namespace stk2k\xstring;

use IteratorAggregate;
use ArrayIterator;
use stk2k\xstring\encoding\Encoding;

class xString implements IteratorAggregate
{
    const DEFAULT_ENCODING = 'UTF-8';

    /** @var $str */
    private $str;

    /** @var string  */
    private $encoding;

    /**
     * mbString constructor.
     *
     * @param string $str
     * @param string $encoding
     */
    public function __construct(string $str, string $encoding = self::DEFAULT_ENCODING)
    {
        $this->str = $str;
        $this->encoding = Encoding::normalize($encoding);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(mb_str_split($this->str, 1, $this->encoding));
    }

    /**
     * Returns if string is empty or not
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->str);
    }

    /**
     * Get raw string
     *
     * @return string
     */
    public function value() : string
    {
        return $this->str;
    }

    /**
     * Set this string to empty
     *
     * @return self
     */
    public function clear() : self
    {
        $this->str = '';
        return $this;
    }

    /**
     * Set string
     *
     * @param string|xString $str
     *
     * @return self
     */
    public function set($str) : self
    {
        $this->str = $str instanceof xString ? $str->value() : "$str";
        return $this;
    }

    /**
     * Returns encoding
     *
     * @return string
     */
    public function getEncoding() : string
    {
        return $this->encoding;
    }

    /**
     * Return character code
     *
     * @return int
     */
    public function ord() : int
    {
        return mb_ord($this->str, $this->encoding);
    }

    /**
     * Make copy
     *
     * @return self
     */
    public function copy() : self
    {
        return new self($this->str);
    }

    /**
     * Make new string object
     *
     * @param string $str
     *
     * @return self
     */
    public function newString(string $str) : self
    {
        return new self($str, $this->encoding);
    }

    /**
     * Get length
     *
     * @return int
     */
    public function length() : int
    {
        return mb_strlen($this->str);
    }

    /**
     * Seach string index
     *
     * @param string|xString $search
     *
     * @return int
     */
    public function indexOf($search) : int
    {
        $search = xs::unbox($search);
        $res = mb_strpos($this->str, $search);
        return $res === false ? -1 : $res;
    }

    /**
     * Check if the string contains specified string
     *
     * @param string|xString $search
     *
     * @return bool
     */
    public function contains($search) : bool
    {
        $search = xs::unbox($search);
        return mb_strpos($this->str, $search) !== false;
    }

    /**
     * Check if the string starts with specified string
     *
     * @param string|xString $str
     *
     * @return bool
     */
    public function startsWith($str) : bool
    {
        $str = xs::unbox($str);
        return mb_strpos($this->str, $str) === 0;
    }

    /**
     * Check if the string ends with specified string
     *
     * @param string|xString $str
     *
     * @return bool
     */
    public function endsWith($str) : bool
    {
        $str = xs::unbox($str);
        return mb_strrpos($this->str, $str) === mb_strlen($this->str) - mb_strlen($str);
    }

    /**
     * Get part of string
     *
     * @param int $start
     * @param int|null $length
     *
     * @return $this
     */
    public function substring(int $start, int $length = null) : self
    {
        $str = is_int($length) ? mb_substr($this->str, $start, $length) : mb_substr($this->str, $start);
        return $this->newString($str);
    }

    /**
     * Remove a part of string
     *
     * @param int $start
     * @param int|null $length
     *
     * @return self
     */
    public function remove(int $start, int $length = null) : self
    {
        $left = mb_substr($this->str, 0, $start);
        $right = (is_int($length) && $length > 0) ? mb_substr($this->str, $start + $length) : '';
        $this->str = $left . $right;
        return $this;
    }

    /**
     * Inserts a string
     *
     * @param int $start
     * @param string $str
     *
     * @return self
     */
    public function insert(int $start, string $str) : self
    {
        $left = mb_substr($this->str, 0, $start);
        $right = mb_substr($this->str, $start);
        $this->str = $left . $str . $right;
        return $this;
    }

    /**
     * Appneds a string
     *
     * @param string|xString $str
     *
     * @return self
     */
    public function append($str) : self
    {
        $str = xs::unbox($str);
        $this->str = $this->str . $str;
        return $this;
    }

    /**
     * Get lower case string
     *
     * @return self
     */
    public function toLower() : self
    {
        $this->str = mb_strtolower($this->str);
        return $this;
    }

    /**
     * Get upper case string
     *
     * @return self
     */
    public function toUpper() : self
    {
        $this->str = mb_strtoupper($this->str);
        return $this;
    }

    /**
     * Truncates string
     *
     * @param int $length
     *
     * @return self
     */
    public function truncate(int $length) : self
    {
        $this->str = mb_substr($this->str, 0, $length);
        return $this;
    }

    /**
     * Split string into string array by seperator
     *
     * @param string|xString $separator
     *
     * @return xStringArray
     */
    public function split($separator = '') : xStringArray
    {
        $separator = xs::unbox($separator);
        if (empty($separator)){
            return new xStringArray(mb_str_split($this->str), $this->encoding);
        }
        return new xStringArray(explode($separator, $this->str), $this->encoding);
    }

    /**
     * Concatenate other string buffer
     *
     * @param ... $targets
     *
     * @return self
     */
    public function concat(... $targets) : self
    {
        foreach($targets as $item){
            $this->str .= xs::toString($item);
        }
        return $this;
    }

    /**
     * Check if the string is same to specified string
     *
     * @param string|xString $value
     *
     * @return bool
     */
    public function equals($value) : bool
    {
        $value = xs::unbox($value);
        return strcmp($this->str, $value) === 0;
    }

    /**
     * Check if the string is same to specified string
     *
     * @param xString $str
     *
     * @return bool
     */
    public function equalsTo(xString $str) : bool
    {
        return strcmp($this->str, $str->value()) === 0;
    }

    /**
     * Compare the string and specified string
     *
     * @param string|xString $value
     *
     * @return int
     */
    public function compare($value) : int
    {
        $value = xs::unbox($value);
        return strcmp($this->str, $value);
    }

    /**
     * Compare the string and specified string
     *
     * @param xString $str
     *
     * @return int
     */
    public function compareTo(xString $str) : int
    {
        return strcmp($this->str, $str->value());
    }

    /**
     * Strip whitespace
     *
     * @param string|xString|null $characters
     *
     * @return self
     */
    public function trim($characters = null) : self
    {
        $characters = xs::unbox($characters);
        $this->str = is_null($characters) ? trim($this->str) : trim($this->str, $characters);
        return $this;
    }

    /**
     * Strip whitespace from start
     *
     * @param string|xString|null $characters
     *
     * @return self
     */
    public function trimStart($characters = null) : self
    {
        $characters = xs::unbox($characters);
        $this->str = is_null($characters) ? ltrim($this->str) : ltrim($this->str, $characters);
        return $this;
    }

    /**
     * Strip whitespace from end
     *
     * @param string|xString|null $characters
     *
     * @return self
     */
    public function trimEnd($characters = null) : self
    {
        $characters = xs::unbox($characters);
        $this->str = is_null($characters) ? rtrim($this->str) : rtrim($this->str, $characters);
        return $this;
    }

    /**
     * Replace string
     *
     * @param string|xString $search
     * @param string|xString $replacement
     *
     * @return self
     */
    public function replace($search, $replacement) : self
    {
        $search = xs::unbox($search);
        $replacement = xs::unbox($replacement);
        $this->str = str_replace($search, $replacement, $this->str);
        return $this;
    }

    /**
     * Replace string by regular expression
     *
     * @param string|xString $pattern
     * @param string|xString $replacement
     *
     * @return self
     */
    public function replaceRegEx($pattern, $replacement) : self
    {
        $pattern = xs::unbox($pattern);
        $replacement = xs::unbox($replacement);
        $this->str = preg_replace($pattern, $replacement, $this->str);
        return $this;
    }

    /**
     * Checks if string matches regular expression
     *
     * $str->match('^[0-9]{40}$', function($matches){
     *      });
     *
     * @param string $regex
     * @param callable $cb
     * @param bool $match_all
     *
     * @return self
     */
    public function match(string $regex, callable $cb, bool $match_all = true) : self
    {
        $subject = $this->encoding === Encoding::UTF8 ? $this->str : $this->encodeTo(Encoding::UTF8);
        $pattern = xs::format("/{0}/u", $regex);
        $res = $match_all ? preg_match_all($pattern, $subject, $matches) : preg_match($pattern, $subject, $matches);
        $cb($matches, $res);
        return $this;
    }

    /**
     * Changes string encoding
     *
     * @param string $encoding
     *
     * @return $this
     */
    public function encodeTo(string $encoding) : self
    {
        return new xString(mb_convert_encoding($this->str, $encoding, $this->encoding));
    }

    /**
     * Processes each characters
     *
     * @param callable $cb
     *
     * @return self
     */
    public function each(callable $cb) : self
    {
        foreach($this as $c){
            $cb($c);
        }
        return $this;
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->str;
    }
}