<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PosteRepository;
use App\Form\ProfilType;
use App\Entity\Poste;
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function show(Request $request, EntityManagerInterface $entityManager): Response
    { 
        $user= $this->getUser(); 
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user'=>$user
        ]);
    }
      /**
     * @Route("/search", name="app_search")
     */
    public function search(Request $request,PosteRepository $postRepository): Response
    { 
        $postes = [];
    if ($request->isMethod("POST")) {
        $domaine = $request->request->get('domaine');
        $addresse = $request->request->get('addresse');
        $nomsocitie = $request->request->get('nomsocitie');

        $em = $this->getDoctrine()->getManager();
        $postes = $em->getRepository(Poste::class)->advanced_search($domaine, $addresse, $nomsocitie);

        return $this->redirectToRoute('app_candidat_recherche', ['postes' => $postes]);
    }

    return $this->render('profil/search.html.twig',[
        'postes' => $postes,
           
    ]);
}

/**
 * @Route("/recherche", name="app_candidat_recherche")
 */
public function recherche(Request $request)
{
    $postes = $request->query->get("postes");
        return $this->render('profil/search.html.twig', [
            'postes' => $postes,
           
        ]);
    }
}
