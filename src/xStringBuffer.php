<?php
declare(strict_types=1);

namespace stk2k\xstring;

use IteratorAggregate;
use Traversable;

final class xStringBuffer implements IteratorAggregate
{
    /** @var xString */
    private $string;

    /**
     * StringBuffer constructor.
     *
     * @param xString|string $str
     * @param int|null $length
     * @param string $fill
     */
    public function __construct($str = '', int $length = null, string $fill = ' ')
    {
        $this->string = $str instanceof xString ? $str : new xString($str);
        if ($length > $this->string->length()){
            $this->fill($length, $fill);
        }
    }

    /**
     * Expands and fills buffer with character
     *
     * @param int $length
     * @param string $fill
     *
     * @return self
     */
    public function fill(int $length, string $fill = ' ') : self
    {
        if (empty($fill))   return $this;

        $fill_length = $length - $this->string->length();
        if ($fill_length <= 0)   return $this;

        $repeat = intval($fill_length / strlen($fill)) + 1;
        $this->string->append(str_repeat($fill, $repeat));
        $this->string->truncate($length);
        return $this;
    }

    /**
     * Returns partial string
     *
     * @param int $start
     * @param int|null $length
     *
     * @return xString
     */
    public function substring(int $start, int $length = null) : xString
    {
        return $this->string->substring($start, $length);
    }

    /**
     * Returns partial string as string buffer
     *
     * @param int $start
     * @param int|null $length
     *
     * @return self
     */
    public function slice(int $start, int $length = null) : self
    {
        $substr = $this->string->substring($start, $length);
        return new self($substr);
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
        $this->string->truncate($length);
        return $this;
    }

    /**
     * Set buffer string
     *
     * @param string|xString $str
     *
     * @return self
     */
    public function set($str) : self
    {
        $this->string->set($str);
        return $this;
    }

    /**
     * Returns buffer string length
     *
     * @return int
     */
    public function length() : int
    {
        return $this->string->length();
    }

    /**
     * @return Traversable
     */
    public function getIterator() : Traversable
    {
        return new xStringIterator($this->string);
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
        return $this->string->split($separator);
    }

    /**
     * Returns if buffer is empty or not
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return $this->string->isEmpty();
    }

    /**
     * Clears buffer
     *
     * @return self
     */
    public function clear() : self
    {
        $this->string->set('');
        return $this;
    }

    /**
     * Add a string to tail position
     *
     * @param string|xString $str
     *
     * @return $this
     */
    public function append($str) : self
    {
        $this->string = $this->string->append($str);
        return $this;
    }

    /**
     * Add a string to head position
     *
     * @param string|xString $str
     *
     * @return $this
     */
    public function prepend($str) : self
    {
        $this->string = $this->string->prepend($str);
        return $this;
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
            $this->string->set($this->string->value() . xs::toString($item));
        }
        return $this;
    }

    /**
     * Returns string object
     *
     * @return xString
     */
    public function toString() : xString
    {
        return $this->string;
    }

    /**
     * Returns string value
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->string->value();
    }
}