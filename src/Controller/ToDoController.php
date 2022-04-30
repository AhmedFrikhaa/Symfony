<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as RequestAlias;
class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'Todo')]
    public function index(RequestAlias $request): Response
    {
        // opening the session
        $session= $request->getSession();
      //if the todo array not existing we are creating one in our session then inputting the content there
        if(!$session->has('todos')){
            $todos= array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens');
            $session->set('todos',$todos);
            $this->addFlash('info', "La liste des todos est viens d'etre initialisée");
        }
        // show the array if it's already created
        return $this->render('to_do/index.html.twig');
    }
    #[Route('/todo/add/{name}/{content}' , name : 'todo.add')]
    public function addTodo(RequestAlias $request ,$name ,$content):RedirectResponse{
        //verifier si j'ai mon tableau de todo dans la session
        $session=$request->getSession();
        if ($session->has('todos')){
            //si oui
            $todos=$session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('error', "ce todo $name existe deja dans le tableau de Todos");

            }
            $todos[$name]=$content;
            $session->set('todos',$todos);
            $this->addFlash('succes', "le todo $name  est ajouté Maintenant !");
        }
        //si non
        else {
            // afficher une erreur et on va  redigier vers le controlleur index

            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");

        }
            return $this->redirectToRoute('Todo');

        }
    #[Route('/todo/update/{name}/{content}' , name : 'todo.update')]
    public function updateTodo(RequestAlias $request ,$name ,$content):RedirectResponse{
        //verifier si j'ai mon tableau de todo dans la session
        $session=$request->getSession();
        if ($session->has('todos')){
            //si oui
            $todos=$session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "ce todo $name n'existe pas dans le tableau de Todos");

            }
            $todos[$name]=$content;
            $session->set('todos',$todos);
            $this->addFlash('succes', "le todo $name  est mise à jour Maintenant !");
        }
        //si non
        else {
            // afficher une erreur et on va  redigier vers le controlleur index

            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");

        }
        return $this->redirectToRoute('Todo');

    }
    #[Route('/todo/supp/{name}' , name : 'todo.Delete')]
    public function suppTodo(RequestAlias $request ,$name ):RedirectResponse{
        //verifier si j'ai mon tableau de todo dans la session
        $session=$request->getSession();
        if ($session->has('todos')){
            //si oui
            $todos=$session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "ce todo $name n'existe pas dans le tableau de Todos");

            }
            unset($todos[$name]);
            $session->set('todos',$todos);
            $this->addFlash('succes', "le todo $name  est supprimé Maintenant !");
        }
        //si non
        else {
            // afficher une erreur et on va  redigier vers le controlleur index

            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");

        }
        return $this->redirectToRoute('Todo');

    }
    #[Route('/todo/reset' , name : 'todo.reset ')]
    public function resetTodo(RequestAlias $request):RedirectResponse{
        //verifier si j'ai mon tableau de todo dans la session
        $session=$request->getSession();
        $session->remove('todos');
        $this->addFlash("succes","le todo est vide mainteant ");

        return $this->redirectToRoute('Todo');

    }



}
