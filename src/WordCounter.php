<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class WordCounter
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = \mb_strtolower($text);
    }

    public function count(int $limit = 5, string $pattern = '/[\s,]+/'): array
    {
        $words = \preg_split($pattern, $this->text);

        if ($words === false) {
            throw new RuntimeException('An error occurred while parsing the string.');
        }

        if (isset($words[0]) && empty($words[0])) {
            return [];
        }

        $result = [];
        foreach ($words as $word) {
            $result[$word] = (isset($result[$word]) ? ++$result[$word] : 1);
        }

        \arsort($result);

        return \array_slice($result, 0, $limit);
    }
}
