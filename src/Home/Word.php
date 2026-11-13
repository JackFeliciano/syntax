<?php

declare(strict_types=1);

namespace Syntax\Home;

/**
 * One word in a sentence, tagged with the class it carries. The class decides
 * whether the word can stand as a core or only orbit one.
 */
final class Word
{
    public function __construct(
        public readonly string $text,
        public readonly string $wordClass,
    ) {
    }

    public function isCore(): bool
    {
        return in_array($this->wordClass, ['noun', 'pronoun', 'verb', 'adjective'], true);
    }
}
