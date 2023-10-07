<?php

namespace App\Controller;
use App\Repository\ProjetspersonnelRepository;
use App\Entity\Multimedia;
use App\Entity\Projetspersonnel;
use App\Form\ProjetsparsonnelFormType;
use App\Form\MultimediaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
/**
 * @Route("/projetspersonnel")
 */
class ProjetspersonnelController extends AbstractController
{
       /**
     * @Route("/", name="app_projetspersonnels_index", methods={"GET"})
     */
    public function index(ProjetspersonnelRepository $projetspersonnelRepository): Response
    {
        return $this->render('projetspersonnels/index.html.twig', [
            'projetspersonnels' => $projetspersonnelRepository->findAll(),
        ]);
    }
   /**
     * @Route("/add", name="app_projetspersonnel", methods={"GET", "POST"})
     */
    public function addProjet(Request $request,SluggerInterface $slugger): Response
    {
        $projetspersonnel = new Projetspersonnel();
        $user= $this->getUser();
       
        $form = $this->createForm(ProjetsparsonnelFormType::class, $projetspersonnel);
        $entityManager = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $projetspersonnel->setUser($user);
           
           
            $entityManager->persist($projetspersonnel);
            $entityManager->flush();
            $multimedias=$request->get("multimedias");
            foreach($multimedias as $data){
                $multimedia=new Multimedia();
                $multimedia->setType($data);
                $multimedia->setLien($data);
                $multimedia->setProjetspersonnel($projetspersonnel);
               
                    $entityManager->persist($multimedia);
                    $entityManager->flush();   
                        return $this->redirectToRoute('app_projetspersonnel');
                    }
                }
                    return $this->render('projetspersonnels/index1.html.twig', [
                        'projetspersonnelForm' => $form->createView(),
                        'user'=>$user
            
        ]);
    
}
     /**
     * @Route("/{id}", name="app_projetspersonnels_show", methods={"GET"})
     */
    public function show(Projetspersonnel $projetspersonnel): Response
    {
        return $this->render('projetspersonnels/show.html.twig', [
            'projetspersonnel' => $projetspersonnel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_projetspersonnels_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Projetspersonnel $projetspersonnel, ProjetspersonnelRepository $projetspersonnelRepository): Response
    {
        $form = $this->createForm(ProjetsparsonnelFormType::class, $projetspersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projetspersonnelRepository->add($projetspersonnel, true);

            return $this->redirectToRoute('app_projetspersonnels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projetspersonnels/edit.html.twig', [
            'projetspersonnel' => $projetspersonnel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_projetspersonnels_delete", methods={"POST"})
     */
    public function delete(Request $request, Projetspersonnel $projetspersonnel, ProjetspersonnelRepository $projetspersonnelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projetspersonnel->getId(), $request->request->get('_token'))) {
            $projetspersonnelRepository->remove($projetspersonnel, true);
        }

        return $this->redirectToRoute('app_projetspersonnels_index', [], Response::HTTP_SEE_OTHER);
    }
}