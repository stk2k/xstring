<?php
declare(strict_types=1);

namespace stk2k\xstring;

use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use Traversable;
use Countable;
use JsonSerializable;

final class xStringArray implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable
{
    /** @var string[] */
    private $values;

    /** @var string  */
    private $encoding;

    /**
     * StringArray constructor.
     *
     * @param array $values
     * @param string $encoding
     */
    public function __construct(array $values = [], string $encoding = xString::DEFAULT_ENCODING)
    {
        $this->values = $values;
        $this->encoding = $encoding;
    }

    /**
     * @return array|string[]
     */
    public function values() : array
    {
        return $this->values;
    }

    /**
     * @param $offset
     *
     * @return mixed|string|null
     */
    public function get($offset)
    {
        return $this->values[$offset] ?? null;
    }

    /**
     * @param string $str
     *
     * @return $this
     */
    public function append(string $str) : self
    {
        $this->values[] = $str;
        return $this;
    }

    /**
     * @param int $index
     * @param string $str
     *
     * @return $this
     */
    public function setAt(int $index, string $str) : self
    {
        if ($index >= 0 && $index < count($this->values)){
            $this->values[$index] = $str;
        }
        return $this;
    }

    /**
     * Join array elements with a string
     *
     * @param string $seperator
     *
     * @return xString
     */
    public function join(string $seperator) : xString
    {
        $str = implode($seperator, $this->values);
        return new xString($str, $this->encoding);
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->values);
    }

    /**
     * @return Traversable
     */
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->values);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset) : bool
    {
        return isset($this->values[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed|string
     */
    public function offsetGet($offset)
    {
        return $this->values[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->values[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->values[$offset]);
    }

    /**
     * @return array|string[]
     */
    public function jsonSerialize(): array
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return json_encode($this->values);
    }
}