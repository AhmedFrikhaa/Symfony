<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class SessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        if($session->has('nbVisite')) {
            $nombre_visite = $session->get('nbVisite')+1;
            $session->set('nbVisite',$nombre_visite);
        }else{
            $session->set('nbVisite',1);
        }
        return $this->render('session/index.html.twig',

        );
    }
}
