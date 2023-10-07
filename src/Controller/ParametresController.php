<?php

namespace App\Controller;
use App\Entity\Parametres;
use App\Form\ParametresFormType;
use App\Repository\ParametresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @Route("/parametres")
 */
class ParametresController extends AbstractController
{
    /**
     * @Route("/", name="app_parametress_index", methods={"GET"})
     */
    public function index(ParametresRepository $parametresRepository): Response
    {
        return $this->render('parametress/index.html.twig', [
            'parametres' => $parametresRepository->findAll(),
        ]);
    }

     /**
     * @Route("/add", name="app_parametres", methods={"GET", "POST"})
     */
    public function addParametres(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
       
        $parametres = new Parametres();
        $user= $this->getUser();
        $form = $this->createForm(ParametresFormType::class, $parametres);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('Cv')->getData();
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
            $parametres->setCv  ("uploads/photoProfil/".($newFilename));
            $parametres->setUser($user);
            $parametres = $form->getData();
            $entityManager->persist($parametres);
            $entityManager->flush();

            return $this->redirectToRoute('app_parametres');
        }

       
        return $this->render('parametress/index1.html.twig', [
            'parametresForm' => $form->createView(),
            'user'=>$user
        ]);
}
 /**
     * @Route("/{id}", name="app_parametress_show", methods={"GET"})
     */
    public function show(Parametres $parametre): Response
    {
        return $this->render('parametress/show.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_parametress_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Parametres $parametre, ParametresRepository $parametresRepository): Response
    {
        $form = $this->createForm(ParametresFormType::class, $parametre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametresRepository->add($parametre, true);

            return $this->redirectToRoute('app_parametress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametress/edit.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_parametress_delete", methods={"POST"})
     */
    public function delete(Request $request, Parametres $parametre, ParametresRepository $parametresRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parametre->getId(), $request->request->get('_token'))) {
            $parametresRepository->remove($parametre, true);
        }

        return $this->redirectToRoute('app_parametress_index', [], Response::HTTP_SEE_OTHER);
    }
}