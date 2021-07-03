Basic string library
=======================

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stk2k/xstring.svg?style=flat-square)](https://packagist.org/packages/stk2k/xstring)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://api.travis-ci.com/stk2k/xstring.svg?branch=main)](https://api.travis-ci.com/stk2k/xstring.svg?branch=main)
[![Coverage Status](https://coveralls.io/repos/github/stk2k/xstring/badge.svg?branch=master)](https://coveralls.io/github/stk2k/xstring?branch=master)
[![Code Climate](https://codeclimate.com/github/stk2k/xstring/badges/gpa.svg)](https://codeclimate.com/github/stk2k/xstring)
[![Total Downloads](https://img.shields.io/packagist/dt/stk2k/xstring.svg?style=flat-square)](https://packagist.org/packages/stk2k/xstring)

## Description

Basic string library


## Feature

   - Supports ascii string and multibyte string
   - Provide facade interface(xs)

## Usage

### Facade interface(xs)

```php
use stk2k\xstring\xs;

// Length
echo xs::length('Hello');    // 5
echo xs::length('你好');    // 2

// Join
echo xs::join(',', [1,2,3]);    // 1,2,3

// Index of
echo xs::indexOf('Hello', 'e');    // 1

// Contains
echo xs::contains('Hello', 'ell');    // true

// Starts with
echo xs::startsWith('Hello', 'He');    // true

// Ends with
echo xs::endsWith('Hello', 'lo');    // true

// Substring
echo xs::substring('Hello', 1, 2);    // el

// Remove
echo xs::remove('Hello', 1, 2);    // Hlo

// Insert
echo xs::insert('Hello World!', 5, ',');    // Hello, World!

// To lower case
echo xs::toLower('Hello');    // hello

// To upper case
echo xs::toUpper('Hello');    // HELLO

// Trim left and right
echo xs::trim(' [Hello] ');    // [Hello]

// Trim left
echo xs::trimStart(' [Hello] ', ' [');    // Hello]

// Trim right
echo xs::trimEnd(' [Hello] ', ' ]');    // [Hello

// Replace
echo xs::replace('Hello, World!', 'o', 'e');    // Helle, Werld!

// Replace by regular expression
echo xs::replaceRegEx('Hello, World!', '/o/', 'e');    // Helle, Werld!

// method chain
echo xs::trim(' [Hello] ')->toLower()->remove(1,2);    // [hlo]

// format
//  - see more samples: https://github.com/stk2k/xstring-format
echo xs::format('Hello, {0}!', 'David');    // Hello, David!

// foreach
xs::each('Hello', function($c){
    echo $c . '.';    // H.e.l.l.o.
});
```

### global function(s)

```php
use function stk2k\xstring\globals\s;

echo s('Hello');                // Hello
echo s('Hello')->length();      // 5
echo s('Hello')->toLower();     // hello

// foreach
foreach(s('Hello') as $c){
    echo $c . '.';    // H.e.l.l.o.
}

```

### xStringArray

```php
use stk2k\xstring\xStringArray;

$sa = new xStringArray(['a', 'b', 'c']);

echo count($sa);                // 3
foreach($sa as $i) echo $i;     // abc
echo $sa->join(',');            // a,b,c
echo $sa->get(1);               // b
echo $sa[1];                    // b
unset($sa[1]);
echo $sa;                       // {"0":"a","2":"c"}
$sa[1] = 'Foo';
echo $sa;                       // {"0":"a","2":"c","1":"Foo"}
```

### xStringBuffer

```php
use stk2k\xstring\xStringBuffer;

$b = new xStringBuffer('abc');
$c = new xStringBuffer('a,b,c');

echo $b->length();                  // 3
echo $c->length();                  // 5
foreach($b as $i) echo $i;          // abc
echo json_encode($c->split(','));   // ["a","b","c"]
echo json_encode($b->split());      // ["a","b","c"]
echo $b->append('d');               // abcd
```


## Requirement

PHP 7.2 or later

## Installing stk2k/xstring

The recommended way to install stk2k/xstring is through
[Composer](http://getcomposer.org).

```bash
composer require stk2k/xstring
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## License
This library is licensed under the MIT license.

## Author

[stk2k](https://github.com/stk2k)

## Disclaimer

This software is no warranty.

We are not responsible for any results caused by the use of this software.

Please use the responsibility of the your self.
