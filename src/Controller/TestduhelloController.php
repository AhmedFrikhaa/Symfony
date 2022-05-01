<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestduhelloController extends AbstractController
{
   // #[Route('/testduhello', name: 'app_testduhello')]
    public function index($name , $firstname): Response
    {
        return $this->render('testduhello/index.html.twig', [
            'nom'=>$name,
            'firstname'=>$firstname
        ]);
    }
}
