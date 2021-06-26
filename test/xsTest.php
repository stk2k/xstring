<?php /** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlDialectInspection */
declare(strict_types=1);

namespace stk2k\xstring\test;

use PHPUnit\Framework\TestCase;
use stk2k\xstring\xs;
use stk2k\xstring\xString;

final class xsTest extends TestCase
{

    public function testFormat()
    {
        $this->assertEquals('Hello, Jane!', xs::format('Hello, {0}!', 'Jane'));
    }
    public function testJoin()
    {
        $this->assertEquals('1,2,3', xs::join(',', [1, 2, 3]));
        $this->assertEquals('hello:1.23', xs::join(':', ['hello', 1.23]));
        $this->assertEquals('SELECT * FROM a WHERE b=1 AND c=2 AND d=3', xs::join(' AND ', ['SELECT * FROM a WHERE b=1', 'c=2', 'd=3']));
    }
    public function testNewString()
    {
        $this->assertInstanceOf(xString::class, xs::newString('Hello'));
        $this->assertInstanceOf(xString::class, xs::newString('你好'));
    }
    public function testLength()
    {
        $this->assertEquals(0, xs::length(''));
        $this->assertEquals(5, xs::length('Hello'));
        $this->assertEquals(2, xs::length('你好'));
    }
    public function testEquals()
    {
        $this->assertTrue(xs::equals('', ''));
        $this->assertFalse(xs::equals('', 'Hello'));
        $this->assertTrue(xs::equals('Hello', 'Hello'));
        $this->assertFalse(xs::equals('Hello', '你好'));
        $this->assertTrue(xs::equals('你好', '你好'));
    }
    public function testCompare()
    {
        $this->assertEquals(0, xs::compare('', ''));
        $this->assertLessThan(0, xs::compare('', 'Hello'));
        $this->assertEquals(0, xs::compare('Hello', 'Hello'));
        $this->assertLessThan(0, xs::compare('Hello', '你好'));
        $this->assertGreaterThan(0, xs::compare('你好', '你'));
        $this->assertLessThan(0, xs::compare('你好', '好'));
        $this->assertEquals(0, xs::compare('你好', '你好'));
    }
    public function testIndexOf()
    {
        $this->assertLessThan(0, xs::indexOf('', 'Hello'));
        $this->assertEquals(0, xs::indexOf('Hello', 'H'));
        $this->assertGreaterThan(0, xs::indexOf('Hello', 'ell'));
        $this->assertGreaterThan(0, xs::indexOf('Hello', 'lo'));
        $this->assertLessThan(0, xs::indexOf('Hello', 'R'));
        $this->assertGreaterThan(0, xs::indexOf('Hello, Milo', 'lo'));
        $this->assertEquals(0, xs::indexOf('你好', '你好'));
        $this->assertGreaterThan(0, xs::indexOf('你好', '好'));
        $this->assertLessThan(0, xs::indexOf('你好', '嗎'));
    }
    public function testContains()
    {
        $this->assertFalse(xs::contains('', 'Hello'));
        $this->assertTrue(xs::contains('Hello', 'H'));
        $this->assertTrue(xs::contains('Hello', 'ell'));
        $this->assertTrue(xs::contains('Hello', 'lo'));
        $this->assertFalse(xs::contains('Hello', 'R'));
        $this->assertTrue(xs::contains('Hello, Milo', 'lo'));
        $this->assertTrue(xs::contains('你好', '你好'));
        $this->assertTrue(xs::contains('你好', '你'));
        $this->assertTrue(xs::contains('你好', '好'));
        $this->assertFalse(xs::contains('你好', '嗎'));
    }
    public function testStartsWith()
    {
        $this->assertFalse(xs::startsWith('', 'Hello'));
        $this->assertTrue(xs::startsWith('Hello', 'H'));
        $this->assertFalse(xs::startsWith('Hello', 'ell'));
        $this->assertFalse(xs::startsWith('Hello', 'lo'));
        $this->assertFalse(xs::startsWith('Hello', 'R'));
        $this->assertFalse(xs::startsWith('Hello, Milo', 'lo'));
        $this->assertTrue(xs::startsWith('你好', '你好'));
        $this->assertTrue(xs::startsWith('你好', '你'));
        $this->assertFalse(xs::startsWith('你好', '好'));
        $this->assertFalse(xs::startsWith('你好', '嗎'));
    }
    public function testEndsWith()
    {
        $this->assertFalse(xs::endsWith('', 'Hello'));
        $this->assertFalse(xs::endsWith('Hello', 'H'));
        $this->assertFalse(xs::endsWith('Hello', 'ell'));
        $this->assertTrue(xs::endsWith('Hello', 'lo'));
        $this->assertFalse(xs::endsWith('Hello', 'R'));
        $this->assertTrue(xs::endsWith('Hello, Milo', 'lo'));
        $this->assertTrue(xs::endsWith('你好', '你好'));
        $this->assertFalse(xs::endsWith('你好', '你'));
        $this->assertTrue(xs::endsWith('你好', '好'));
        $this->assertFalse(xs::endsWith('你好', '嗎'));
    }
    public function testSubstring()
    {
        $this->assertEquals('', xs::substring('', 1));
        $this->assertEquals('ello', xs::substring('Hello', 1));
        $this->assertEquals('el', xs::substring('Hello', 1, 2));
        $this->assertEquals('', xs::substring('Hello', 5));
        $this->assertEquals('lo', xs::substring('Hello', -2));
        $this->assertEquals('好', xs::substring('你好', 1));
        $this->assertEquals('我叫', xs::substring('你好,我叫鈴木友美.', 3, 2));
    }
    public function testRemove()
    {
        $this->assertEquals('', xs::remove('', 1));
        $this->assertEquals('H', xs::remove('Hello', 1));
        $this->assertEquals('Hlo', xs::remove('Hello', 1, 2));
        $this->assertEquals('Hello', xs::remove('Hello', 5));
        $this->assertEquals('Hel', xs::remove('Hello', -2));
        $this->assertEquals('你', xs::remove('你好', 1));
        $this->assertEquals('你好,鈴木友美.', xs::remove('你好,我叫鈴木友美.', 3, 2));
    }
    public function testInsert()
    {
        $this->assertEquals('', xs::insert('', 1, ''));
        $this->assertEquals('Hello', xs::insert('Hello', 1, ''));
        $this->assertEquals('HRello', xs::insert('Hello', 1, 'R'));
        $this->assertEquals('Hello!', xs::insert('Hello', 5, '!'));
        $this->assertEquals('Hel,lo', xs::insert('Hello', -2, ','));
        $this->assertEquals('你,好', xs::insert('你好', 1, ','));
        $this->assertEquals('你好,我,叫鈴木友美.', xs::insert('你好,我叫鈴木友美.', 4, ','));
    }
    public function testToLower()
    {
        $this->assertEquals('', xs::toLower(''));
        $this->assertEquals('hello, world!', xs::toLower('Hello, World!'));
        $this->assertEquals('你好', xs::toLower('你好'));
        $this->assertEquals('τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός', xs::toLower('Τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός'));
    }
    public function testToUpper()
    {
        $this->assertEquals('', xs::toUpper(''));
        $this->assertEquals('HELLO, WORLD!', xs::toUpper('Hello, World!'));
        $this->assertEquals('你好', xs::toUpper('你好'));
        $this->assertEquals('ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ ΒΑΦΉΣ ΨΗΜΈΝΗ ΓΗ, ΔΡΑΣΚΕΛΊΖΕΙ ΥΠΈΡ ΝΩΘΡΟΎ ΚΥΝΌΣ', xs::toUpper('Τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός'));
    }
    public function testTrim()
    {
        $this->assertEquals('', xs::trim(''));
        $this->assertEquals('Hello, World!', xs::trim(' Hello, World! '));
        $this->assertEquals('Hello, World!', xs::trim("\nHello, World!\t"));
        $this->assertEquals('你好', xs::trim('你好'));
        $this->assertEquals('你好', xs::trim(' 你好 '));
        $this->assertEquals('你好', xs::trim("\n你好\t"));
    }
    public function testTrimStart()
    {
        $this->assertEquals('', xs::trimStart(''));
        $this->assertEquals('Hello, World! ', xs::trimStart(' Hello, World! '));
        $this->assertEquals("Hello, World!\t", xs::trimStart("\nHello, World!\t"));
        $this->assertEquals('你好', xs::trimStart('你好'));
        $this->assertEquals('你好 ', xs::trimStart(' 你好 '));
        $this->assertEquals("你好\t", xs::trimStart("\n你好\t"));
    }
    public function testTrimEnd()
    {
        $this->assertEquals('', xs::trimEnd(''));
        $this->assertEquals(' Hello, World!', xs::trimEnd(' Hello, World! '));
        $this->assertEquals("\nHello, World!", xs::trimEnd("\nHello, World!\t"));
        $this->assertEquals('你好', xs::trimEnd('你好'));
        $this->assertEquals(' 你好', xs::trimEnd(' 你好 '));
        $this->assertEquals("\n你好", xs::trimEnd("\n你好\t"));
    }
    public function testReplace()
    {
        $this->assertEquals('', xs::replace('', 'e', 'o'));
        $this->assertEquals('Hollo, World!', xs::replace('Hello, World!', 'e', 'o'));
        $this->assertEquals('你呢', xs::replace('你好','好','呢'));
    }
    public function testReplaceRegEx()
    {
        $this->assertEquals('o', xs::replaceRegEx('', '//', 'o'));
        $this->assertEquals('Hoooo, Woooo!', xs::replaceRegEx('Hello, World!', '/[a-z]/', 'o'));
        $this->assertEquals('Helroo, Mairoo!', xs::replaceRegEx('Hello, Mailo!', '/lo/', 'roo'));
        $this->assertEquals('你呢呢', xs::replaceRegEx('你好好','/好/','呢'));
    }
    public function testSplit()
    {
        $this->assertEquals(['a','b','c'], xs::split('a,b,c', ',')->values());
        $this->assertEquals(['あ','いb','うc'], xs::split('あ,いb,うc', ',')->values());
    }
}