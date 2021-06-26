<?php
declare(strict_types=1);

namespace stk2k\xstring;

use IteratorAggregate;
use Traversable;

class xStringIterator implements IteratorAggregate
{
    /** @var xString  */
    private $value;

    /**
     * StringIterator constructor.
     *
     * @param xString $value
     */
    public function __construct(xString $value)
    {
        $this->value = $value;
    }

    public function getIterator(): Traversable
    {
        for($i = 0; $i < $this->value->length(); $i++) {
            yield $this->value->substring($i, 1);
        }
    }
}