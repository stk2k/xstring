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
     * @param xString|null $str
     */
    public function __construct(xString $str = null, int $length = null, string $fill = ' ')
    {
        $this->string = $str ?? new xString('');
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
     * @param xString $str
     *
     * @return self
     */
    public function set(xString $str) : self
    {
        $this->string = $str;
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
        $this->string = new xString('');
        return $this;
    }

    /**
     * Append a string to buffer
     *
     * @param string $str
     *
     * @return $this
     */
    public function append(string $str) : self
    {
        $this->string = $this->string->append($str);
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
            if ($item instanceof xStringBuffer){
                $this->string->set($this->string->value() . $item->string->value());
            }
            else if ($item instanceof xString){
                $this->string->set($this->string->value() . $item->value());
            }
            else if (is_string($item) || is_int($item) || is_float($item)){
                $this->string->set($this->string->value() . $item);
            }
            else if ($item === true){
                $this->string->set($this->string->value() . 'true');
            }
            else if ($item === false){
                $this->string->set($this->string->value() . 'false');
            }
            else if (is_object($item) && method_exists($item, '__toString')){
                $this->string->set($this->string->value() . $item->__toString());
            }
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