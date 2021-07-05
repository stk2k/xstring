<?php
declare(strict_types=1);

namespace stk2k\xstring\test\encoding;

use PHPUnit\Framework\TestCase;
use stk2k\xstring\encoding\Encoding;

final class EncodingTest extends TestCase
{
    public function testNormalize()
    {
        // UTF-8
        $this->assertEquals(Encoding::UTF8, Encoding::normalize('utf-8'));
        $this->assertEquals(Encoding::UTF8, Encoding::normalize('UTF-8'));
        $this->assertEquals(Encoding::UTF8, Encoding::normalize('UTF8'));
        $this->assertEquals(Encoding::UTF8, Encoding::normalize('utf8'));

        // EUC-JP
        $this->assertEquals(Encoding::EUC_JP, Encoding::normalize('EUC-JP'));

        // SJIS
        $this->assertEquals(Encoding::SJIS, Encoding::normalize('Shift_JIS'));
        $this->assertEquals(Encoding::SJIS, Encoding::normalize('sjis'));
    }
}