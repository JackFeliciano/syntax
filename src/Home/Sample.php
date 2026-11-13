<?php

declare(strict_types=1);

namespace Syntax\Home;

final class Sample
{
    public static function engine(): Engine
    {
        return new Engine();
    }

    /** @return list<Sentence> */
    public static function sentences(): array
    {
        $one = new Sentence('S-01', 'The bridge is narrow');
        $one->add(new Word('The bridge', 'noun'));
        $one->add(new Word('is', 'verb'));
        $one->add(new Word('narrow', 'adjective'));

        $two = new Sentence('S-02', 'The crew painted the bridge');
        $two->add(new Word('The crew', 'noun'));
        $two->add(new Word('painted', 'verb'));
        $two->add(new Word('the bridge', 'noun'));

        $three = new Sentence('S-03', 'The clerk handed the driver a form');
        $three->add(new Word('The clerk', 'noun'));
        $three->add(new Word('handed', 'verb'));
        $three->add(new Word('the driver', 'noun'));
        $three->add(new Word('a form', 'noun'));

        $four = new Sentence('S-04', 'The crew rested');
        $four->add(new Word('The crew', 'noun'));
        $four->add(new Word('rested', 'verb'));

        $five = new Sentence('S-05', 'The crew rested on the bank');
        $five->add(new Word('The crew', 'noun'));
        $five->add(new Word('rested', 'verb'));
        $five->add(new Word('on', 'preposition'));
        $five->add(new Word('the bank', 'noun'));

        return [$one, $two, $three, $four, $five];
    }
}
