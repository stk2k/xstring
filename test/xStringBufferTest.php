<?php
declare(strict_types=1);

namespace stk2k\xstring\test;

use PHPUnit\Framework\TestCase;
use stk2k\xstring\xString;
use stk2k\xstring\xStringBuffer;
use function stk2k\xstring\globals\s;

final class xStringBufferTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertEquals(1, (new xStringBuffer('a'))->length());
        $this->assertEquals(1, (new xStringBuffer(s('a')))->length());
    }
    public function testLength()
    {
        $this->assertEquals(0, (new xStringBuffer(new xString('')))->length());
        $this->assertEquals(3, (new xStringBuffer(new xString('abc')))->length());
        $this->assertEquals(3, (new xStringBuffer(new xString('ハワイ')))->length());
        $this->assertEquals(5, (new xStringBuffer(new xString('ハワイ')))->append('bc')->length());
        $this->assertEquals(4, (new xStringBuffer(new xString('ハワイ')))->append('島')->length());
    }
    public function testSplit()
    {
        $this->assertEquals([], (new xStringBuffer(new xString('')))->split('')->values());
        $this->assertEquals(['a',',','b',',','c'], (new xStringBuffer(new xString('a,b,c')))->split()->values());
        $this->assertEquals(['a','b','c'], (new xStringBuffer(new xString('a,b,c')))->split(',')->values());
        //echo json_encode((new xStringBuffer(new xString('abc')))->split(''));  // ['a','b','c']
    }
    public function testIsEmpty()
    {
        $this->assertTrue((new xStringBuffer(new xString('')))->isEmpty());
        $this->assertFalse((new xStringBuffer(new xString('a')))->isEmpty());
        $this->assertTrue((new xStringBuffer(new xString('a')))->clear()->isEmpty());
    }
    public function testClear()
    {
        $this->assertEquals('', (new xStringBuffer(new xString('a')))->clear());
    }
    public function testAppend()
    {
        $this->assertEquals('abc', (new xStringBuffer(new xString('a')))->append('b')->append('c'));
        $this->assertEquals('abcd', (new xStringBuffer(new xString('abc')))->append('d'));
    }
    public function testForeach()
    {
        $str = 'abc';
        foreach(new xStringBuffer(new xString($str)) as $key => $c){
            $this->assertEquals(substr($str,$key,1), $c);
        }
        $str = 'ハワイ';
        foreach(new xStringBuffer(new xString($str)) as $key => $c){
            $this->assertEquals(mb_substr($str,$key,1), $c);
        }
    }
    public function testSubstring()
    {
        $str = 'Hello, World!';
        $this->assertEquals('el', (new xStringBuffer(new xString($str)))->substring(1,2));
        $this->assertEquals('Hello', (new xStringBuffer(new xString($str)))->substring(0,5));
        $this->assertEquals('World!', (new xStringBuffer(new xString($str)))->substring(7));
        $this->assertEquals('d!', (new xStringBuffer(new xString($str)))->substring(-2));
    }
    public function testSlice()
    {
        $str = 'Hello, World!';
        $this->assertEquals('el', (new xStringBuffer(new xString($str)))->slice(1,2));
        $this->assertEquals('Hello', (new xStringBuffer(new xString($str)))->slice(0,5));
        $this->assertEquals('World!', (new xStringBuffer(new xString($str)))->slice(7));
        $this->assertEquals('d!', (new xStringBuffer(new xString($str)))->slice(-2));
    }
    public function testTruncate()
    {
        $str = 'Hello, World!';
        $this->assertEquals('He', (new xStringBuffer(new xString($str)))->truncate(2));
        $this->assertEquals('Hello', (new xStringBuffer(new xString($str)))->truncate(5));
    }
    public function testFill()
    {
        $str = 'Hello';
        $this->assertEquals('Hello               ', (new xStringBuffer(new xString($str)))->fill(20, ' '));
        $this->assertEquals('Hello===============', (new xStringBuffer(new xString($str)))->fill(20, '='));
        $this->assertEquals('Hello-=~-=~-=~-=~-=~', (new xStringBuffer(new xString($str)))->fill(20, '-=~'));
    }
    public function testConcat()
    {
        $str = 'Hello';
        $this->assertEquals('Hello,', (new xStringBuffer(new xString($str)))->concat(','));
        $this->assertEquals('Hello, World!', (new xStringBuffer(new xString($str)))->concat(',', ' World!'));
        $this->assertEquals('Hello, Sandy!', (new xStringBuffer(new xString($str)))->concat(new xStringBuffer(new xString(', Sandy!'))));
        $this->assertEquals('Hello', (new xStringBuffer(new xString($str)))->concat(null));
        $this->assertEquals('Hello:-1:0:3.14', (new xStringBuffer(new xString($str)))->concat(":", -1, ":", 0, ":", 3.14));
        $this->assertEquals('Hello:true:false', (new xStringBuffer(new xString($str)))->concat(":", true, ":", false));
    }
}