<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Renderer
{
    private Environment $twig;

    public function __construct($basePath)
    {
        $loader = new FilesystemLoader(__DIR__ . $basePath);
        $this->twig = new Environment($loader);
    }

    public function render(View $view): string
    {
        return $this->twig->render($view->getPath() . '.html.twig', $view->getData());
    }
}