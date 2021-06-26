<?php
declare(strict_types=1);

namespace stk2k\xstring\test;

use PHPUnit\Framework\TestCase;
use stk2k\string\MultibyteString;
use stk2k\xstring\xString;
use stk2k\xstring\xStringBuffer;

final class xStringTest extends TestCase
{
    public function testEncoding()
    {
        $str = new xString('a', 'UTF-8');

        $this->assertEquals('UTF-8', $str->getEncoding());

        $str = new xString('a', 'Windows-1252');

        $this->assertEquals('Windows-1252', $str->getEncoding());
    }
    public function testOrd()
    {
        $str = new xString('あ', 'UTF-8');

        $this->assertEquals(12354, $str->ord());

        $str = new xString('你好', 'UTF-8');

        $this->assertEquals(20320, $str->ord());
    }
    public function testTruncate()
    {
        $str = '隣の客はよく柿食う客だ';

        $this->assertEquals('', (new xString($str))->truncate(0));
        $this->assertEquals(0, (new xString($str))->truncate(0)->length());
        $this->assertEquals('隣の客はよ', (new xString($str))->truncate(5));
        $this->assertEquals(5, (new xString($str))->truncate(5)->length());
    }
    public function testConcat()
    {
        $str = 'こんにちは';

        $this->assertEquals('こんにちは,', (new xString($str))->concat(','));
        $this->assertEquals('こんにちは, World!', (new xString($str))->concat(',', ' World!'));
        $this->assertEquals('こんにちは, 你好!', (new xString($str))->concat(new xStringBuffer(new xString(', 你好!'))));
        $this->assertEquals('こんにちは', (new xString($str))->concat(null));
        $this->assertEquals('こんにちは:-1:0:3.14', (new xString($str))->concat(":", -1, ":", 0, ":", 3.14));
        $this->assertEquals('こんにちは:true:false', (new xString($str))->concat(":", true, ":", false));
    }

}