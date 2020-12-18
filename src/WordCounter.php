<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class WordCounter
{
    public function count(string $text, int $limit = 5, string $pattern = '/[\s,]+/'): array
    {
        $words = \preg_split($pattern, \mb_strtolower($text));

        if ($words === false) {
            throw new RuntimeException('An error occurred while parsing the string.');
        }

        if (empty($words[0])) {
            return [];
        }

        $result = [];
        foreach ($words as $word) {
            $result[$word] = isset($result[$word]) ? ++$result[$word] : 1;
        }

        \arsort($result);

        return \array_slice($result, 0, $limit);
    }
}
