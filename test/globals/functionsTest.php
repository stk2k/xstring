<?php
declare(strict_types=1);

namespace stk2k\xstring\test\globals;

use PHPUnit\Framework\TestCase;
use stk2k\xstring\xString;
use function stk2k\xstring\globals\s;

final class functionsTest extends TestCase
{
    public function testXs()
    {
        $xs = s();

        $this->assertInstanceOf(xString::class, $xs);

        $xs = s('Foo');

        $this->assertInstanceOf(xString::class, $xs);

        $xs = s('あお', 'UTF-8');

        $this->assertInstanceOf(xString::class, $xs);

        $xs = s(file_get_contents('test/data/euc-jp.txt'), 'EUC-JP');

        $this->assertInstanceOf(xString::class, $xs);
    }
}