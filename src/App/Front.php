<?php

declare(strict_types=1);

namespace Syntax\App;

use Syntax\Home\Sample;

final class Front
{
    public function __construct(private readonly string $base)
    {
    }

    public function run(): void
    {
        $router = new Router($this->base);
        $views = new Views($this->base);
        $engine = Sample::engine();
        $sentences = Sample::sentences();
        $today = getenv('SYNTAX_TODAY') ?: '12 November 2026';

        $router->get('/', static fn (): array => [200, [
            'html' => $views->front($engine, $sentences, $today),
        ]]);

        $router->get('/status', static fn (): array => [200, ['json' => [
            'ok' => true,
            'schemes' => count($engine->schemes()),
            'sentences' => count($sentences),
            'sorted' => $engine->sort($sentences[1]),
        ]]]);

        [$status, $body] = $router->handle(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/',
        );

        http_response_code($status);
        if (isset($body['json'])) {
            header('Content-Type: application/json');
            echo json_encode($body['json'], JSON_UNESCAPED_SLASHES), "\n";

            return;
        }
        if (isset($body['html'])) {
            header('Content-Type: text/html; charset=utf-8');
            echo $body['html'];

            return;
        }
        header('Content-Type: text/html; charset=utf-8');
        echo $views->notFound((string) ($body['path'] ?? '/'));
    }
}
