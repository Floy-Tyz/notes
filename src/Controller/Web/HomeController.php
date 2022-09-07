<?php

namespace App\Controller\Web;

use App\AbstractEntity\BaseAbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseAbstractController
{
    #[Route("/", name: "home", methods: ["GET"])]
    public function home(): Response
    {
        return $this->render('pages/home.html.twig');
    }

//    #[Route("/categories/{any?}", name: "categories", requirements: ["any" => ".*"], methods: ["GET"])]
//    public function categories(): Response
//    {
//        return $this->render('pages/home.html.twig');
//    }
}
