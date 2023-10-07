<?php

namespace App\Controller;
use App\Entity\Diplome;
use App\Repository\EducationRepository;
use App\Entity\Education;
use App\Form\EducationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
/**
 * @Route("/education")
 */
class EducationController extends AbstractController
{    
    /**
     * @Route("/", name="app_educations_index", methods={"GET"})
     */
    public function index(EducationRepository $educationRepository): Response
    {
        return $this->render('educations/index.html.twig', [
            'education' => $educationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="app_education", methods={"GET", "POST"})
     */
    public function addeducation(Request $request): Response
    {
        $education = new Education();
        $user= $this->getUser();
       
        $form = $this->createForm(EducationFormType::class, $education);
        $entityManager = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $education->setUser($user);
           
            //var_dump($form["mission"]->getData());
            $entityManager->persist($education);
            $entityManager->flush();
            $diplomes=$request->get("diplomes");
            foreach($diplomes as $data){
                $diplome=new Diplome();
                $diplome->setMontion($data);
                $diplome->setAnnee($data);
                $diplome->setEducation($education);

                $entityManager->persist($diplome);
                $entityManager->flush();   
            } 
           
            return $this->redirectToRoute('app_education');
        }

        return $this->render('educations/index1.html.twig', [
            'educationForm' => $form->createView(),
            'user'=>$user
            
        ]);
    }
    /**
     * @Route("/{id}", name="app_educations_show", methods={"GET"})
     */
    public function show(Education $education): Response
    {
        return $this->render('educations/show.html.twig', [
            'education' => $education,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_educations_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Education $education, EducationRepository $educationRepository): Response
    {
        $form = $this->createForm(EducationFormType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $educationRepository->add($education, true);

            return $this->redirectToRoute('app_educations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('educations/edit.html.twig', [
            'education' => $education,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_educations_delete", methods={"POST"})
     */
    public function delete(Request $request, Education $education, EducationRepository $educationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$education->getId(), $request->request->get('_token'))) {
            $educationRepository->remove($education, true);
        }

        return $this->redirectToRoute('app_educations_index', [], Response::HTTP_SEE_OTHER);
    }
}
