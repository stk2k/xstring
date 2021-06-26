<?php
declare(strict_types=1);

namespace stk2k\xstring\globals;

use function function_exists;

use stk2k\xstring\xString;

if (!function_exists('s')){
    function s(?string $s = '', string $encoding = xString::DEFAULT_ENCODING) : xString
    {
        return new xString($s, $encoding);
    }
}