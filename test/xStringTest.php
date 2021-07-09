<?php
declare(strict_types=1);

namespace stk2k\xstring\test;

use PHPUnit\Framework\TestCase;
use stk2k\xstring\encoding\Encoding;
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
    public function testTraversable()
    {
        $str = 'こんにちは';

        $pos = 0;
        foreach(new xString($str) as $c){
            $this->assertEquals(mb_substr($str, $pos, 1), $c);
            $pos ++;
        }
    }
    public function testEach()
    {
        $str = 'こんにちは';

        ob_start();
        (new xString($str))->each(function($c){
            echo $c . '.';
        });
        $text = ob_get_clean();
        $this->assertEquals('こ.ん.に.ち.は.', $text);
    }
    public function testEncodeTo()
    {
        $str = file_get_contents('test/data/euc-jp.txt');
        $encoded = (new xString($str, Encoding::EUC_JP))->encodeTo(Encoding::UTF8);
        $this->assertEquals('あおい地球', $encoded);
        $this->assertEquals(Encoding::UTF8, $encoded->getEncoding());

        $str = file_get_contents('test/data/sjis.txt');
        $encoded = (new xString($str, Encoding::SJIS))->encodeTo(Encoding::UTF8);
        $this->assertEquals('あおい地球', $encoded);
        $this->assertEquals(Encoding::UTF8, $encoded->getEncoding());

        $str = file_get_contents('test/data/sjis.txt');
        $encoded = (new xString($str, Encoding::SJIS))->encodeTo(Encoding::EUC_JP);
        $this->assertEquals(file_get_contents('test/data/euc-jp.txt'), $encoded);
        $this->assertEquals(Encoding::EUC_JP, $encoded->getEncoding());
    }
    public function testMatch()
    {
        $str = 'Hello, World!';
        $res = (new xString($str))->match('/lo/');
        $this->assertEquals(['lo'], $res->values());

        $str = 'Foo123, Bar456, Foo789';
        $res = (new xString($str))->match('/Foo([0-9]+)/');
        $this->assertEquals(['Foo123','123'], $res->values());

        $str = 'Hello, World!';
        $res = (new xString($str))->match('/[a-z]/');
        $this->assertEquals(['e'], $res->values());

        $str = 'Hello, World!';
        $res = (new xString($str))->match('/([a-z]+),([\sA-Z]+)/');
        $this->assertEquals(['ello, W', 'ello', ' W'], $res->values());

        $str = 'となりのきゃくはよくかきくうきゃくだ';
        $res = (new xString($str))->match('/き/u');
        $this->assertEquals(['き'], $res->values());

        $str = 'となりのきゃくはよくかきくうきゃくだ';
        $res = (new xString($str))->match('/さ/u');
        $this->assertEquals([], $res->values());
    }

    public function testMatchAll()
    {
        $str = 'Hello, World!';
        $res = (new xString($str))->matchAll('/lo/');
        $this->assertSame([['lo']], $res->values());

        $str = 'Foo123, Bar456, Foo789';
        $res = (new xString($str))->matchAll('/Foo([0-9]+)/');
        $this->assertSame([['Foo123','Foo789'],['123','789']], $res->values());

        $str = 'Hello, World!';
        $res = (new xString($str))->matchAll('/[a-z]/');
        $this->assertSame([['e','l','l','o','o','r','l','d']], $res->values());

        $str = 'Hello, World!';
        $res = (new xString($str))->matchAll('/([a-z]+),([\sA-Z]+)/');
        $this->assertSame([['ello, W'], ['ello'], [' W']], $res->values());

        $str = 'となりのきゃくはよくかきくうきゃくだ';
        $res = (new xString($str))->matchAll('/き/u');
        $this->assertSame([['き','き','き']], $res->values());

        $str = 'となりのきゃくはよくかきくうきゃくだ';
        $res = (new xString($str))->matchAll('/さ/u');
        $this->assertSame([[]], $res->values());
    }

    public function testAppend()
    {
        $str = 'Hello';
        $res = (new xString($str))->append(', World!');
        $this->assertSame('Hello, World!', $res->value());

        $str = 'こんにちは';
        $res = (new xString($str))->append(', 世界!');
        $this->assertSame('こんにちは, 世界!', $res->value());
    }

    public function testPrepend()
    {
        $str = ', World!';
        $res = (new xString($str))->prepend('Hello');
        $this->assertSame('Hello, World!', $res->value());

        $str = ', 世界!';
        $res = (new xString($str))->prepend('こんにちは');
        $this->assertSame('こんにちは, 世界!', $res->value());
    }

}