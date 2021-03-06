<?php declare(strict_types=1);
/*
The MIT License (MIT)

Copyright (c) 2017 Tim Düsterhus

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

namespace Bastelstube\ParserCombinator\Test\Parser;

use Bastelstube\ParserCombinator;
use function Bastelstube\ParserCombinator\{char, choice, many, satisfyChar, stringP, tryP};

class CharTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRejectsEmpty()
    {
        char('');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRejectsLong()
    {
        char('ä.');
    }

    public function testParsesChar()
    {
        $parser = char('ä');
        $input = new ParserCombinator\Input('ä');

        ParserCombinator\Parser::parse($parser, $input)->either(function ($message) {
            $this->fail((string) $message);
        }, function ($result) {
            $this->assertSame('ä', $result->getResult());
        });
    }

    public function testDoesNotParseInvalidChar()
    {
        $parser = char('ä');
        $input = new ParserCombinator\Input('a');

        ParserCombinator\Parser::parse($parser, $input)->either(function ($message) {
            $this->assertTrue(true);
        }, function ($result) {
            $this->fail($result->getResult());
        });

        $input = new ParserCombinator\Input('ö');

        ParserCombinator\Parser::parse($parser, $input)->either(function ($message) {
            $this->assertTrue(true);
        }, function ($result) {
            $this->fail($result->getResult());
        });
    }
}
