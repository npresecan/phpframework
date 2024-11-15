<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ServiceTwig
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../../cache',
            'debug' => true,
        ]);
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}