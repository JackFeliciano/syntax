<?php

declare(strict_types=1);

namespace Syntax\Home;

/**
 * A sentence the engine sorts into one of five schemes. The cores are the
 * subject, the verb and the subject complement. The adjuncts orbit them and a
 * scheme still holds when they come out.
 */
final class Sentence
{
    /** @var list<Word> */
    private array $words = [];

    public function __construct(public readonly string $id, public readonly string $text)
    {
    }

    public function add(Word $word): void
    {
        $this->words[] = $word;
    }

    /** @return list<Word> */
    public function words(): array
    {
        return $this->words;
    }

    /** @return list<Word> */
    public function cores(): array
    {
        $out = [];
        foreach ($this->words as $word) {
            if ($word->isCore()) {
                $out[] = $word;
            }
        }

        return $out;
    }

    /** @return list<Word> */
    public function adjuncts(): array
    {
        $out = [];
        foreach ($this->words as $word) {
            if (!$word->isCore()) {
                $out[] = $word;
            }
        }

        return $out;
    }

    public function verb(): ?Word
    {
        foreach ($this->words as $word) {
            if ($word->wordClass === 'verb') {
                return $word;
            }
        }

        return null;
    }

    public function hasClass(string $wordClass): bool
    {
        foreach ($this->words as $word) {
            if ($word->wordClass === $wordClass) {
                return true;
            }
        }

        return false;
    }
}
