<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parametres;
use App\Entity\User;
use App\Form\ParametresFormType;
use App\Repository\ParametresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @Route("/recruteur" )
 */
class RecruteurController extends AbstractController
{ 

    /**
     * @Route("/tableau-de-bord", name="app_recruteur-dashboard")
     */
    public function dashboard(Request $request)
    {
        $users = [];
        if($request->isMethod("POST"))
        {
            $domaine    = $request->request->get('domaine');
            $experience = $request->request->get('experience');
            $certificat = $request->request->get('certificat');
            $competence = $request->request->get('competence');
            $niveau     = $request->request->get('niveau');
            $em=$this->getDoctrine()->getManager();
            $users= $em->getRepository(User::class)->advanced_search($domaine,$experience,$certificat,$competence,$niveau);
            return $this->redirectToRoute('app_recruteur_recherche',array('users'=>$users));
        }
        return $this->render('recruteur/index.html.twig', [ 
             'users' =>$users
        ]);
    }

    /**
     * @Route("/recherche", name="app_recruteur_recherche")
     */
    public function search(Request $request)
    {
        $users = $request->query->get("users");
        return $this->render('recruteur/index.html.twig', [ 
            'users' =>$users
       ]);
    }

    /**
     * @Route("/rec", name="app_profil_rec")
     */
    public function index(): Response
    {
        $user= $this->getUser();
        return $this->render('recruteur/profil.html.twig', [
            'controller_name' => 'RecruteurController',
            'user' => $user
        ]);
    }
         /**
     * @Route("/add", name="app_parametres_rec", methods={"GET", "POST"})
     */
    public function addParametres(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
       
        $parametres = new Parametres();
        $user= $this->getUser();
        $form = $this->createForm(ParametresFormType::class, $parametres);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('photo')->getData();
            if ($imageFile )
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension(); 
              
                try 
                { 
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                }catch(FileException $e){}
            }
            // Save the image file path to your database
            $parametres->setPhotoCouv  ("uploads/photoProfil/".($newFilename));
            $parametres->setUser($user);
            $parametres = $form->getData();
            $entityManager->persist($parametres);
            $entityManager->flush();

            return $this->redirectToRoute('app_parametres_rec');
        }

        return $this->render('recruteur/ajouter.html.twig', [
            'parametresForm' => $form->createView(),
            'user'=>$user
        ]);
}
/**
 * @Route("/portfolio/{link}", name="app_portfolio_link_public") 
 */
public function portfolio(Request $request,$link):Reponse
{
    $em = $this->getDoctrine()->getManager();
    $parametresRepository = $em->getRepository(Parametres::class);
    $parametre = $parametresRepository->findOneBy(["linkPublic" => $link]);

    if ($parametre !== null) {
        $user = $parametre->getUser();

        return $this->render('profil/index.html.twig', [
            'user' => $user
        ]);
    } else {
        throw $this->createNotFoundException('Page not found');
    }

}

}