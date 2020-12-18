<?php

declare(strict_types=1);

namespace App\Tests;

use App\WordCounter;
use PHPUnit\Framework\TestCase;

class WordCounterTest extends TestCase
{
    private WordCounter $wordCounter;

    protected function setUp(): void
    {
        $this->wordCounter = new WordCounter();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCount(string $text, array $expected)
    {
        self::assertEquals($expected, $this->wordCounter->count($text));
    }

    public function testSort()
    {
        $result = $this->wordCounter->count('test word test word word');

        self::assertEquals('word', \array_key_first($result));
        self::assertEquals('test', \array_key_last($result));
    }

    public function testSortUnicodeString()
    {
        $result = $this->wordCounter->count('привет мир привет   мир мир');

        self::assertEquals('мир', \array_key_first($result));
        self::assertEquals('привет', \array_key_last($result));
    }

    public function testTop5()
    {
        $result = $this->wordCounter->count('test word test word word aa bb dd dd ddd fff sss');
        self::assertCount(5, $result);
        self::assertEquals(['word' => 3, 'test' => 2, 'dd' => 2, 'aa' => 1, 'bb' => 1], $result);
    }

    public function testLimit()
    {
        $result = $this->wordCounter->count('test word test word word aa bb dd dd ddd fff sss', 6);

        self::assertCount(6, $result);
        self::assertEquals(['word' => 3, 'test' => 2, 'dd' => 2, 'aa' => 1, 'bb' => 1, 'ddd' => 1], $result);
    }

    public function dataProvider()
    {
        return [
            ['test word test word word', ['test' => 2, 'word' => 3]],
            ['test,word,test,word , word', ['test' => 2, 'word' => 3]],
            ['', []],
            ['привет мир привет   мир мир', ['привет' => 2, 'мир' => 3]],
        ];
    }
}
