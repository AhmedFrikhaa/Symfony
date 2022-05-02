<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Sodium\add;

#[Route('/personne')]
class PersonneController extends AbstractController
{
   #[Route('/' , name:'personne.list')]
   public function index(ManagerRegistry $doctrine):Response{
        $entityManger=$doctrine->getRepository(Personne::class);
        $personnes=$entityManger->findAll();
        return $this->render("personne/index.html.twig",['personnes'=>$personnes]);
    }
       #[Route('/alls/age/{ageMin}/{ageMax}' , name:'personne.list.age')]
       public function PersonneByAge(ManagerRegistry $doctrine , $ageMin,$ageMax):Response{
       $repository=$doctrine->getRepository(Personne::class);
       $personnes=$repository->findPersonnesByAgeIntervalle($ageMin,$ageMax);
        return $this->render('personne/index.html.twig',['personnes'=>$personnes]);

       }
       #[Route('/alls/statage/{ageMin}/{ageMax}' , name:'personne.list.stat.age')]
       public function statPersonneByAge(ManagerRegistry $doctrine , $ageMin,$ageMax):Response{
        $repository=$doctrine->getRepository(Personne::class);
        $stat=$repository->statfindPersonnesByAgeIntervalle($ageMin,$ageMax);
        return $this->render('personne/stat.html.twig',['stat'=>$stat[0] , 'ageMin'=>$ageMin , 'ageMax'=>$ageMax]);

    }
       #[Route('/alls/{page?1}/{nbr?12}' , name:'personne.alls')]
       public function alls(ManagerRegistry $doctrine,$page , $nbr):Response{
           $entityManger=$doctrine->getRepository(Personne::class);
           $nbrPersonne=$entityManger->count([]);
           $nbrPages=ceil($nbrPersonne/$nbr) ;
           $personnes=$entityManger->findBy([],['age'=>'ASC'],$nbr,($page-1)*$nbr);
           return $this->render("personne/index.html.twig",[
               'personnes'=>$personnes ,
               'isPaginated'=>true,
               'page'=>$page,
               'nbrPages'=>$nbrPages,
               'nbr'=>$nbr]);
       }
       //findAll=findby([]) il retourne tout sans exception
       /*  #[Route('/{id<\d+>}' , name:'personne.detail')]
       public function detail(ManagerRegistry $doctrine , $id):Response
       {
           $entityManger = $doctrine->getRepository(Personne::class);
           $personne = $entityManger->find($id);
           if (!$personne) {
           $this->addFlash('error',"la personne d'id $id n'existe pas ");
           return  $this->redirectToRoute('personne.list');
           }
            else{
                return $this->render("personne/detail.html.twig", ['personne' => $personne]);
           }
       }*/
       //2eme methode
       #[Route('/{id<\d+>}' , name:'personne.detail')]
       public function detail(Personne $personne=null ):Response
    {

        if (!$personne) {

            $this->addFlash('error',"cette personne n'existe pas ");
            return  $this->redirectToRoute('personne.alls');
        }
        else{
            return $this->render("personne/detail.html.twig", ['personne' => $personne]);
        }
    }

       #[Route('/add', name: 'app_personne')]
        public function addPersonne(ManagerRegistry $doctrine): Response
    {
        //$this->addtobd($doctrine,"Ahmed","Frikha",20);
        //$this->addtobd($doctrine,'Ismail',"Frikha",17);

        $entityManger=$doctrine->getManager();
        $personne= new Personne();
        $personne->setFirstname("Ahmed");
        $personne->setName("Frikha");
        $personne->setAge(20);
        $entityManger->persist($personne);
        $entityManger->flush();
        return $this->render('personne/detail.html.twig', [ 'personne'=>$personne

        ]);
    }
       #[Route('/addform', name: 'app_personne')]
       public function addpersonneForm(ManagerRegistry $doctrine , Request $request):Response{
       $personne = new Personne();
       $form=$this->createForm(PersonneType::class, $personne);
       $form->handleRequest($request);

//Est ce  que le formulaire est soumis
       if($form->isSubmitted()) {//si oui
     // on va ajouter l objet al based de donnéé
       $manager=$doctrine->getManager();
       $manager->persist($personne);
       $manager->flush();
     // afficher un message de success (addFlash)
       $this->addFlash("error", $personne->getName() ."est ajouter Maintenant");
     //Rediriger vers la liste des personnes
       return $this->redirectToRoute('personne.alls');
       }else //si non
       {   // on affiche notre formulaire une autre fois
           $this->addFlash("error", "une error a arrivé lors de l'ajout de cette personne .Merci de reremplir le formulaire");
           return  $this->render("personne/add-personne.html.twig", ['form' => $form->createView()]);
           // affiche un message d'error
       }

       }
       #[Route('/delete/{id}',name: 'personne.delete')]
       public function deletePersonne( Personne $personne=null , ManagerRegistry $doctrine  ) : RedirectResponse {

        if($personne){
            $manager=$doctrine->getManager();

            $manager->remove($personne);
            //A NE PAS OUBLIER D'EXECUTER VOTRE CHANGEMENT POUR LA MODIFICATION DE LA BASE DE DONNEES
            $manager->flush();
            $this->addFlash('error',"this person has been deleted successfuly ");

        }
        else{
           $this->addFlash('error',"This person does not exist");
        }
       return $this->redirectToRoute("personne.alls");
   }
       #[Route('/update/{id}/{name}/{firstname}/{age}',name: 'personne.update')]
       public function updatePersonne(Personne $personne=null , ManagerRegistry $doctrine,$name,$firstname,$age) : RedirectResponse {
         if($personne){
             $manager=$doctrine->getManager();
             $this->addFlash('error',"This user has been updated");
             $personne->setName($name);
             $personne->setAge($age);
             $personne->setFirstname($firstname);
             //updating this person with the id
             $manager->persist($personne);
             $manager->flush();
         }
         else{
             $this->addFlash('error', "this user is not found anywhere there is noway to update him ");
         }
         return $this->redirectToRoute('personne.alls');
   }
       #[Route('/edit/{id?0}', name: 'personne.edit')]
       public function editPersonne( Personne $personne=null, ManagerRegistry $doctrine , Request $request,SluggerInterface $slugger):Response
       {   $existance=false;
           if (!$personne) {
               $existance=true;
               $personne = new Personne();
           }
           $form = $this->createForm(PersonneType::class, $personne);
           $form->handleRequest($request);

//Est ce  que le formulaire est soumis
           if ($form->isSubmitted()) {//si oui
               // on va ajouter l objet al based de donnée
               $manager = $doctrine->getManager();
               $manager->persist($personne);
               $brochureFile = $form->get('photo')->getData();

               // this condition is needed because the 'brochure' field is not required
               // so the PDF file must be processed only when a file is uploaded
               if ($brochureFile) {
                   $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                   // this is needed to safely include the file name as part of the URL
                   $safeFilename = $slugger->slug($originalFilename);
                   $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                   // Move the file to the directory where brochures are stored
                   try {
                       $brochureFile->move(
                           $this->getParameter('$Personne_directory'),
                           $newFilename
                       );
                   } catch (FileException $e) {
                       // ... handle exception if something happens during file upload
                   }

                   // updates the 'brochureFilename' property to store the PDF file name
                   // instead of its contents
                   $personne->setImage($newFilename);
               }
               $manager->flush();
               // afficher un message de success (addFlash)
               if(!$existance){
                   $this->addFlash("error", $personne->getName() ." est mis à jour");
               }
               else {
                   $this->addFlash("error", $personne->getName() . " est ajouté Maintenant");
               }
               //Rediriger vers la liste des personnes
               return $this->redirectToRoute('personne.alls');
           } else //si non
           {   // on affiche notre formulaire une autre fois
              return  $this->render("personne/add-personne.html.twig", ['form' => $form->createView()]);
               // affiche un message d'error

           }
       }
}

