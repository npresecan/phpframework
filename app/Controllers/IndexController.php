<?php

namespace App\Controllers;

use App\Responses\Response;
use App\Responses\JsonResponse;
use App\Responses\HtmlResponse;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Requests\Request;

class IndexController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => false, 
            'debug' => true,
        ]);
    }

    public function indexAction(): Response
    {
        return new Response('Bok');
    }
    
    public function indexJsonAction(): JsonResponse
    {
        $data = [
            'message' => 'Bok',
            'status' => 'success'
        ];
        return new JsonResponse($data);
    }

    public function indexHtmlAction(): HtmlResponse
    {
        $content = $this->twig->render('index.html.twig', [
            'title' => 'Bok',
            'message' => 'Ovo je HTML odgovor generiran pomoću Twig-a'
        ]);
        return new HtmlResponse($content);
    }

    public function index(): Response
    {
        return new Response('Praksa');
    }

    public function dodaj(Request $request): Response
    {
        $name = $request->getPostParam('name') ?? 'Gost';
        return new Response('Bok, ' . $name);
    }
}