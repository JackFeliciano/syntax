<?php

declare(strict_types=1);

namespace Syntax\Tests;

use Syntax\Home\Engine;
use Syntax\Home\Sample;
use Syntax\Home\Sentence;
use Syntax\Home\Word;

return [
    ['a linking verb takes scheme one', static function (): void {
        Assert::same('S1', Sample::engine()->sort(Sample::sentences()[0]));
    }],
    ['a direct object takes scheme two', static function (): void {
        Assert::same('S2', Sample::engine()->sort(Sample::sentences()[1]));
    }],
    ['two objects take scheme three', static function (): void {
        Assert::same('S3', Sample::engine()->sort(Sample::sentences()[2]));
    }],
    ['a verb alone takes scheme four', static function (): void {
        Assert::same('S4', Sample::engine()->sort(Sample::sentences()[3]));
    }],
    ['a preposition takes scheme five', static function (): void {
        Assert::same('S5', Sample::engine()->sort(Sample::sentences()[4]));
    }],
    ['an adjunct leaves the scheme standing', static function (): void {
        $engine = new Engine();
        $bare = new Sentence('T-1', 'The crew rested');
        $bare->add(new Word('The crew', 'noun'));
        $bare->add(new Word('rested', 'verb'));
        $withAdjunct = new Sentence('T-2', 'The crew rested yesterday');
        $withAdjunct->add(new Word('The crew', 'noun'));
        $withAdjunct->add(new Word('rested', 'verb'));
        $withAdjunct->add(new Word('yesterday', 'adverb'));
        Assert::same($engine->sort($bare), $engine->sort($withAdjunct));
    }],
    ['a pronoun subject still sorts', static function (): void {
        $sentence = new Sentence('T-3', 'They painted the bridge');
        $sentence->add(new Word('They', 'pronoun'));
        $sentence->add(new Word('painted', 'verb'));
        $sentence->add(new Word('the bridge', 'noun'));
        Assert::same('S2', (new Engine())->sort($sentence));
    }],
    ['a simple sentence carries no coordinator', static function (): void {
        $engine = new Engine();
        $built = $engine->build('simple', 'the crew rested', 'the bridge held');
        Assert::same('The crew rested.', $built);
        Assert::true($engine->check('simple', $built));
    }],
    ['a compound sentence carries a coordinator', static function (): void {
        $engine = new Engine();
        $built = $engine->build('compound', 'the crew rested', 'the bridge held');
        Assert::contains(', and ', $built);
        Assert::true($engine->check('compound', $built));
    }],
    ['a complex sentence opens with a subordinator', static function (): void {
        $engine = new Engine();
        $built = $engine->build('complex', 'the crew rested', 'the bridge held');
        Assert::true(str_starts_with($built, 'When '));
        Assert::true($engine->check('complex', $built));
    }],
    ['a check refuses the wrong kind', static function (): void {
        $engine = new Engine();
        Assert::false($engine->check('complex', 'The crew rested.'));
        Assert::false($engine->check('simple', 'The crew rested, and the bridge held.'));
    }],
    ['the scheme table holds five entries', static function (): void {
        Assert::count(5, (new Engine())->schemes());
    }],
];
