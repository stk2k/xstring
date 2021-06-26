<?php
declare(strict_types=1);

namespace stk2k\xstring;

class xString
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
        $this->encoding = $encoding;
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
     * @param string $str
     *
     * @return self
     */
    public function set(string $str) : self
    {
        $this->str = $str;
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
     * @param string $search
     *
     * @return int
     */
    public function indexOf(string $search) : int
    {
        $res = mb_strpos($this->str, $search);
        return $res === false ? -1 : $res;
    }

    /**
     * Check if the string contains specified string
     *
     * @param string $search
     *
     * @return bool
     */
    public function contains(string $search) : bool
    {
        return mb_strpos($this->str, $search) !== false;
    }

    /**
     * Check if the string starts with specified string
     *
     * @param string $str
     *
     * @return bool
     */
    public function startsWith(string $str) : bool
    {
        return mb_strpos($this->str, $str) === 0;
    }

    /**
     * Check if the string ends with specified string
     *
     * @param string $str
     *
     * @return bool
     */
    public function endsWith(string $str) : bool
    {
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
     * @param string $str
     *
     * @return self
     */
    public function append(string $str) : self
    {
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
     * @param string $separator
     *
     * @return xStringArray
     */
    public function split(string $separator = '') : xStringArray
    {
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
     * @return xString
     */
    public function concat(... $targets) : xString
    {
        foreach($targets as $item){
            if ($item instanceof xStringBuffer){
                $this->str = $this->str . $item->toString()->value();
            }
            else if ($item instanceof xString){
                $this->str = $this->str . $item->value();
            }
            else if (is_string($item) || is_int($item) || is_float($item)){
                $this->str = $this->str . $item;
            }
            else if ($item === true){
                $this->str = $this->str . 'true';
            }
            else if ($item === false){
                $this->str = $this->str . 'false';
            }
            else if (is_object($item) && method_exists($item, '__toString')){
                $this->str = $this->str . $item->__toString();
            }
        }
        return $this;
    }

    /**
     * Check if the string is same to specified string
     *
     * @param string $value
     *
     * @return bool
     */
    public function equals(string $value) : bool
    {
        return strcmp($this->value(), $value) === 0;
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
        return strcmp($this->value(), $str->value()) === 0;
    }

    /**
     * Compare the string and specified string
     *
     * @param string $value
     *
     * @return int
     */
    public function compare(string $value) : int
    {
        return strcmp($this->value(), $value);
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
        return strcmp($this->value(), $str->value());
    }

    /**
     * Strip whitespace
     *
     * @param string|null $characters
     *
     * @return self
     */
    public function trim(string $characters = null) : xString
    {
        $this->str = is_null($characters) ? trim($this->str) : trim($this->str, $characters);
        return $this;
    }

    /**
     * Strip whitespace from start
     *
     * @param string|null $characters
     *
     * @return xString
     */
    public function trimStart(string $characters = null) : xString
    {
        $this->str = is_null($characters) ? ltrim($this->str) : ltrim($this->str, $characters);
        return $this;
    }

    /**
     * Strip whitespace from end
     *
     * @param string|null $characters
     *
     * @return xString
     */
    public function trimEnd(string $characters = null) : xString
    {
        $this->str = is_null($characters) ? rtrim($this->str) : rtrim($this->str, $characters);
        return $this;
    }

    /**
     * Replace string
     *
     * @param string $search
     * @param string $replacement
     *
     * @return $this
     */
    public function replace(string $search, string $replacement) : xString
    {
        $this->str = str_replace($search, $replacement, $this->str);
        return $this;
    }

    /**
     * Replace string by regular expression
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return $this
     */
    public function replaceRegEx(string $pattern, string $replacement) : xString
    {
        $this->str = preg_replace($pattern, $replacement, $this->str);
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