<?php

declare(strict_types=1);

namespace Syntax\Home;

/**
 * The engine sorts a sentence into one of five schemes. It reads the cores in
 * order and returns the first scheme whose shape they match, so the order of
 * the checks carries the ruling.
 */
final class Engine
{
    /** @var array<string, string> */
    private array $schemes = [
        'S1' => 'subject, linking verb, predicate subject',
        'S2' => 'subject, verb, direct object',
        'S3' => 'subject, verb, indirect object, direct object',
        'S4' => 'subject, verb',
        'S5' => 'subject, verb, prepositional object',
    ];

    /** @return array<string, string> */
    public function schemes(): array
    {
        return $this->schemes;
    }

    public function sort(Sentence $sentence): string
    {
        // The preposition decides the prepositional scheme before anything else,
        // because the noun after it is the object of the preposition and not
        // another core.
        if ($sentence->hasClass('preposition')) {
            return 'S5';
        }
        $classes = [];
        foreach ($sentence->cores() as $word) {
            $classes[] = $word->wordClass;
        }
        $shape = implode(' ', $classes);

        if ($shape === 'noun verb adjective') {
            return 'S1';
        }
        if ($shape === 'noun verb noun noun') {
            return 'S3';
        }
        if ($shape === 'noun verb noun' || $shape === 'pronoun verb noun') {
            return 'S2';
        }
        if ($shape === 'noun verb' || $shape === 'pronoun verb') {
            return 'S4';
        }
        if ($shape === 'noun verb adverb') {
            return 'S4';
        }

        return 'S4';
    }

    /**
     * The sentence built from a template, with the learner's words in it. A
     * compound sentence joins two simple ones with a coordinator, and a complex
     * one carries a finite clause under a subordinator.
     */
    public function build(string $kind, string $first, string $second): string
    {
        return match ($kind) {
            'simple' => ucfirst($first) . '.',
            'compound' => ucfirst($first) . ', and ' . $second . '.',
            'complex' => 'When ' . $first . ', ' . $second . '.',
            default => throw new \RuntimeException('unknown kind ' . $kind),
        };
    }

    public function check(string $kind, string $built): bool
    {
        return match ($kind) {
            'simple' => !str_contains($built, ',') && str_ends_with($built, '.'),
            'compound' => str_contains($built, ', and ') && str_ends_with($built, '.'),
            'complex' => str_starts_with($built, 'When ') && str_contains($built, ', '),
            default => false,
        };
    }
}
