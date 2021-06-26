<?php
declare(strict_types=1);

namespace stk2k\xstring\test;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use stk2k\xstring\xStringArray;

final class xStringArrayTest extends TestCase
{
    public function testGet()
    {
        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertEquals('a', $sa->get(0));
        $this->assertEquals('b', $sa->get(1));
        $this->assertEquals('c', $sa->get(2));
        $this->assertNull($sa->get(3));

        $sa[3] = 'Foo';
        $this->assertEquals('Foo', $sa->get(3));
    }
    public function testJoin()
    {
        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertEquals('abc', $sa->join(''));
        $this->assertEquals('a,b,c', $sa->join(','));
        $this->assertEquals('a AND b AND c', $sa->join(' AND '));
    }
    public function testCount()
    {
        $this->assertCount(0, new xStringArray());
        $this->assertCount(0, new xStringArray([]));
        $this->assertCount(1, new xStringArray([1]));
        $this->assertCount(3, new xStringArray([1, 2, 3]));
    }
    public function testGetIterator()
    {
        $it = (new xStringArray())->getIterator();

        $this->assertInstanceOf(ArrayIterator::class, $it);
    }
    public function testOffsetExists()
    {
        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertFalse($sa->offsetExists('a'));
        $this->assertFalse(isset($sa['b']));
        $this->assertTrue(isset($sa[0]));
        $this->assertTrue(isset($sa[1]));
        $this->assertFalse(isset($sa[3]));
    }
    public function testOffsetGet()
    {
        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertNull($sa->offsetGet('a'));
        $this->assertNull($sa['b']);
        $this->assertEquals('a', $sa[0]);
        $this->assertEquals('b', $sa[1]);
        $this->assertNull($sa[3]);
    }
    public function testOffsetSet()
    {
        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertEquals('["a","b","c"]', json_encode($sa));

        $sa[0] = 'Foo';
        $this->assertEquals('["Foo","b","c"]', json_encode($sa));

        $sa[1] = 'Bar';
        $this->assertEquals('["Foo","Bar","c"]', json_encode($sa));

        $sa['a'] = 'Bazz';
        $this->assertEquals('{"0":"Foo","1":"Bar","2":"c","a":"Bazz"}', json_encode($sa));
    }
    public function testOffsetUnset()
    {
        $sa = new xStringArray(['a', 'b', 'c']);

        unset($sa[0]);
        $this->assertEquals('{"1":"b","2":"c"}', json_encode($sa));

        unset($sa[1]);
        $this->assertEquals('{"2":"c"}', json_encode($sa));

        $sa['a'] = 'Bazz';
        $this->assertEquals('{"2":"c","a":"Bazz"}', json_encode($sa));

        $sa[1] = 'Foo';
        $this->assertEquals('{"2":"c","a":"Bazz","1":"Foo"}', json_encode($sa));
    }
    public function testAppend()
    {
        $sa = new xStringArray([]);

        $this->assertEquals('["Foo","Bar"]', json_encode($sa->append('Foo')->append('Bar')));

        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertEquals('["a","b","c","d"]', json_encode($sa->append('d')));
    }
    public function testSetAt()
    {
        $sa = new xStringArray([]);

        $this->assertEquals('[]', json_encode($sa->setAt(0, 'Foo')));

        $sa = new xStringArray(['a', 'b', 'c']);

        $this->assertEquals('["Foo","b","c"]', json_encode($sa->setAt(0, 'Foo')));
        $this->assertEquals('["Foo","Bar","c"]', json_encode($sa->setAt(1, 'Bar')));
        $this->assertEquals('["Foo","Bar","c"]', json_encode($sa->setAt(-1, 'Baz')));
    }
}