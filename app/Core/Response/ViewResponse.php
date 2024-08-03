<?php

namespace App\Core\Response;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewResponse implements ResponseInterface
{
    public function __construct(
        private string $view,
        private array $data = [],
        private int $statusCode = 200,
    )
    {
    }

    public function render()
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code($this->statusCode);
        $loader = new FilesystemLoader(realpath(__DIR__ . '/../../../views'));
        $twig = new Environment($loader);
        $template = $twig->load($this->view);

        echo $template->render($this->data);
    }
}