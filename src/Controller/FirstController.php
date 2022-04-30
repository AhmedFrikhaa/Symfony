<?php

namespace App\Controller;

use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig',[
            'name'=> 'ahmed'

        ]);


    }
    #[Route('/sayHello/{name}', name: 'sayHello')]
    public function sayHello( Request $request ,$name): Response
    {


       // $rand=rand(0,6);
       // echo $rand;
       // if($rand%2==0){
            return  $this->render('first/sayHello.html.twig',[
                'nom'=>$name
            ]);
        //}
       // return $this->forward('App\Controller\FirstController::index');


    }
}
