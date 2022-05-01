<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb?5</d+>}', name: 'tab')]
    public function index($nb): Response
    {
        $notes = [];
        for ($i = 0; $i < $nb; $i++) {
            $notes[] = rand(0, 100);

        }
        return $this->render('tab/index.html.twig', [
            'notes' => $notes,
        ]);
    }

    #[Route('/tab/users', name: 'tab.users')]
    public function users(): Response
    {
        $users=[
            ['firstname'=>'ahmed','name'=>'frikha', 'age'=>'20'],
            ['firstname'=>'hanen','name'=>'trabelsi', 'age'=>'45'],
            ['firstname'=>'edam','name'=>'frikha', 'age'=>'13']
        ];
       return $this->render('tab/user.html.twig',[
       'users'=>$users]);
    }
}