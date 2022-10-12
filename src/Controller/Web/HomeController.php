<?php

namespace App\Controller\Web;

use App\Infrastructure\AbstractClass\BaseAbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseAbstractController
{
    #[Route("/", name: "notes.list", methods: ["GET"])]
    public function notesList(): Response
    {
        return $this->render('pages/home.html.twig');
    }

    #[Route("/notes/{slug}/{id}", name: "notes.view", methods: ["GET"])]
    public function notesView(): Response
    {
        return $this->render('pages/home.html.twig');
    }
}
