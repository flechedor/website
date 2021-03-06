<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bnomei\HTMLHead;
use PHPUnit\Framework\TestCase;

final class HtmlheadTest extends TestCase
{
    public function testSnippets()
    {
        $this->setOutputCallback(function () {
        });

        $snippets = HTMLHead::snippets(page('home'));
        $this->assertIsString($snippets);

        $this->assertStringContainsString('<title>Home</title>', $snippets);
        $this->assertStringContainsString('<base href="/">', $snippets);
        $this->assertStringContainsString('<meta property="robots" content="index, follow, noodp">', $snippets);
        $this->assertStringContainsString('<meta property="author" content="">', $snippets);
        $this->assertStringContainsString('<meta property="description" content="Orgia de talis rector, manifestum nuptia.">', $snippets);
        $this->assertStringContainsString('<link href="/assets/app.css" rel="stylesheet">', $snippets);
        $this->assertStringContainsString('<script src="/assets/app.js"></script>', $snippets);
        $this->assertStringContainsString('<script crossorigin="anonymous" integrity="sha256-4O4pS1SH31ZqrSO2A/2QJTVjTPqVe+jnYgOWUVr7EEc=" src="https://cdn.jsdelivr.net/npm/webfontloader@1.6.28/webfontloader.min.js"></script>', $snippets);
        $this->assertStringContainsString('<link href="https://github.com/ffoodd/a11y.css/blob/master/css/a11y-en_errors-only.css" media="screen" rel="stylesheet">', $snippets);
        $this->assertStringContainsString('<link href="/feed" rel="alternate" title="Home" type="application/rss+xml">', $snippets);
        $this->assertStringContainsString('Montserrat', $snippets);
    }
}
