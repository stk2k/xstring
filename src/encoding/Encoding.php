<?php
declare(strict_types=1);

namespace stk2k\xstring\encoding;

final class Encoding
{
    const UTF8            = 'UTF-8';
    const SJIS            = 'SJIS';
    const SJIS_WIN        = 'SJIS-win';
    const EUC_JP          = 'EUC-JP';
    const EUCJP_WIN       = 'eucJP-win';

    public static function normalize(string $encoding) : string
    {
        switch(strtolower($encoding)){
            case 'utf8':
            case 'utf-8':
                $encoding = self::UTF8;
                break;

            case 'euc-jp':
                $encoding = self::EUC_JP;
                break;

            case 'sjis':
            case 'shiftjis':
            case 'shift_jis':
                $encoding = self::SJIS;
                break;
        }

        return $encoding;
    }
}