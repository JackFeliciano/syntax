<?php

declare(strict_types=1);

namespace Syntax\App;

use Syntax\Home\Engine;
use Syntax\Home\Sentence;

final class Views
{
    public function __construct(private readonly string $base)
    {
    }

    private function h(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function header(string $title): string
    {
        $base = $this->h($this->base);

        return <<<HTML
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{$this->h($title)}</title>
<base href="{$base}">
<link rel="stylesheet" href="assets/site.css">
</head>
<body>
<main>
HTML;
    }

    public function footer(): string
    {
        return "</main>\n</body>\n</html>\n";
    }

    public function notFound(string $path): string
    {
        return $this->header('Not found')
            . '<h1>Not found</h1>' . "\n"
            . '<p class="stage">' . $this->h($path) . ' is not a route here.</p>' . "\n"
            . $this->footer();
    }

    /** @param list<Sentence> $sentences */
    public function front(Engine $engine, array $sentences, string $today): string
    {
        $out = $this->header('Syntagma');
        $out .= '<h1>Syntagma. A sentence sorted into its scheme</h1>' . "\n";
        $out .= '<p class="lede">Syntagma rests on the Generative Grammar of Noah Chomsky. The engine sorts every sentence into one of five construction schemes.</p>' . "\n";
        $out .= '<p class="stage">' . count($engine->schemes()) . ' schemes, ' . count($sentences) . ' sentences, as of ' . $this->h($today) . '.</p>' . "\n";

        $out .= '<h2>Schemes</h2>' . "\n";
        $out .= '<dl>';
        foreach ($engine->schemes() as $code => $shape) {
            $out .= '<dt>' . $this->h($code) . '</dt><dd>' . $this->h($shape) . '</dd>';
        }
        $out .= '</dl>' . "\n";

        $out .= '<h2>Sorted</h2>' . "\n";
        $out .= '<table class="tiers">' . "\n";
        $out .= '<thead><tr><th>Sentence</th><th>Scheme</th><th>Cores</th><th>Adjuncts</th></tr></thead>' . "\n";
        $out .= '<tbody>' . "\n";
        foreach ($sentences as $sentence) {
            $cores = [];
            foreach ($sentence->cores() as $word) {
                $cores[] = $word->text;
            }
            $adjuncts = [];
            foreach ($sentence->adjuncts() as $word) {
                $adjuncts[] = $word->text;
            }
            $out .= '<tr><td>' . $this->h($sentence->text) . '</td>'
                . '<td><span class="badge on">' . $this->h($engine->sort($sentence)) . '</span></td>'
                . '<td>' . $this->h(implode(' / ', $cores)) . '</td>'
                . '<td>' . $this->h(implode(' / ', $adjuncts)) . '</td></tr>' . "\n";
        }
        $out .= '</tbody>' . "\n" . '</table>' . "\n";

        $out .= '<h2>Built</h2>' . "\n";
        $out .= '<div class="cards">' . "\n";
        foreach (['simple', 'compound', 'complex'] as $kind) {
            $built = $engine->build($kind, 'the crew rested', 'the bridge held');
            $out .= '<article class="card">' . "\n";
            $out .= '<h3>' . ucfirst($this->h($kind)) . '</h3>' . "\n";
            $out .= '<p>' . $this->h($built) . '</p>' . "\n";
            $out .= '<dl><dt>Check</dt><dd>' . ($engine->check($kind, $built) ? 'passes' : 'fails') . '</dd></dl>' . "\n";
            $out .= '</article>' . "\n";
        }
        $out .= '</div>' . "\n";
        $out .= $this->footer();

        return $out;
    }
}
