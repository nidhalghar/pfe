<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/poste")
 */
class PosteController extends AbstractController
{
    /**
     * @Route("/", name="app_poste_index", methods={"GET"})
     */
    public function index(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
        ]);
    }

    /**
      * @Route("/add", name="app_postule", methods={"GET","POST"})
     */
    public function addCertificat(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $poste = new Poste();
        $user= $this->getUser();
        $form = $this->createForm(PosteType::class, $poste);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $imageFile = $form->get('photo')->getData();
            if ($imageFile )
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension(); 
                // Move the file to the directory where images are stored
                try 
                { 
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                }catch(FileException $e){}
            }
            // Save the image file path to your database
            $poste->setAffiche  ("uploads/photoProfil/".($newFilename));
            
            $poste->setUser($user);
            $poste = $form->getData();
            $entityManager->persist($poste);
            $entityManager->flush();

            return $this->redirectToRoute('app_postule');
        }

        return $this->render('recruteur/poste.html.twig', [
            'PosteForm' => $form->createView(),
            'user'=>$user
        ]);
    }

    /**
     * @Route("/{id}", name="app_poste_show", methods={"GET"})
     */
    public function show(Poste $poste): Response
    {
        return $this->render('poste/show.html.twig', [
            'poste' => $poste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_poste_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Poste $poste, PosteRepository $posteRepository): Response
    {
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->add($poste, true);

            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('poste/edit.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_poste_delete", methods={"POST"})
     */
    public function delete(Request $request, Poste $poste, PosteRepository $posteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poste->getId(), $request->request->get('_token'))) {
            $posteRepository->remove($poste, true);
        }

        return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
    }
}
