<?php

declare(strict_types=1);

namespace App\Tests;

use App\WordCounter;
use PHPUnit\Framework\TestCase;

class WordCounterTest extends TestCase
{
    public function testCountSeparatorSpace()
    {
        $wordCounter = new WordCounter('test word test word word');

        self::assertEquals(['test' => 2, 'word' => 3], $wordCounter->count());
    }

    public function testCountComma()
    {
        $wordCounter = new WordCounter('test,word,test,word , word');

        self::assertEquals(['test' => 2, 'word' => 3], $wordCounter->count());
    }

    public function testCountEmpty()
    {
        $wordCounter = new WordCounter('');

        self::assertEquals([], $wordCounter->count());
    }

    public function testCountUnicodeString()
    {
        $wordCounter = new WordCounter('привет мир привет   мир мир');

        self::assertEquals(['привет' => 2, 'мир' => 3], $wordCounter->count());
    }

    public function testSort()
    {
        $wordCounter = new WordCounter('test word test word word');
        $result = $wordCounter->count();

        self::assertEquals('word', \array_key_first($result));
        self::assertEquals('test', \array_key_last($result));
    }

    public function testSortUnicodeString()
    {
        $wordCounter = new WordCounter('привет мир привет   мир мир');
        $result = $wordCounter->count();

        self::assertEquals('мир', \array_key_first($result));
        self::assertEquals('привет', \array_key_last($result));
    }

    public function testTop5()
    {
        $wordCounter = new WordCounter('test word test word word aa bb dd dd ddd fff sss');

        self::assertCount(5, $wordCounter->count());
        self::assertEquals(['word' => 3, 'test' => 2, 'dd' => 2, 'aa' => 1, 'bb' => 1], $wordCounter->count());
    }

    public function testLimit()
    {
        $wordCounter = new WordCounter('test word test word word aa bb dd dd ddd fff sss');
        $result = $wordCounter->count(6);

        self::assertCount(6, $result);
        self::assertEquals(['word' => 3, 'test' => 2, 'dd' => 2, 'aa' => 1, 'bb' => 1, 'ddd' => 1], $result);
    }
}
