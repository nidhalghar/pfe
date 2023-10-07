<?php

namespace App\Controller;
use App\Entity\Mission;
use App\Entity\Projet;
use App\Entity\Experience;
use App\Form\ExperienceFormType;
use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
/**
 * @Route("/experience")
 */
class ExperienceController extends AbstractController
{
    /**
     * @Route("/", name="app_experiences_index", methods={"GET"})
     */
    public function index(ExperienceRepository $experienceRepository): Response
    {
        return $this->render('experiences/index.html.twig', [
            'experiences' => $experienceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="app_experience", methods={"GET", "POST"})
     */
    public function addExperience(Request $request): Response
    {
        $experience = new Experience();
        $user= $this->getUser();
       
        $form = $this->createForm(ExperienceFormType::class, $experience);
        $entityManager = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $experience->setUser($user);
           
            //var_dump($form["mission"]->getData());
            $entityManager->persist($experience);
            $entityManager->flush();
            $missions=$request->get("missions");
            foreach($missions as $data){
                $mission=new Mission();
                $mission->setPoste($data);
                $mission->setExperience($experience);

                $entityManager->persist($mission);
                $entityManager->flush();   
            } 
            $projets=$request->get("projets");
            foreach($projets as $data){
                $projet=new Projet();
                $projet->setDescription($data);
                $projet->setTechnologies($data);
                $projet->setExperience($experience);
                $entityManager->persist($projet);
                $entityManager->flush();   
            }
            return $this->redirectToRoute('app_experience');
        }

        return $this->render('experiences/index1.html.twig', [
            'experienceForm' => $form->createView(),
            'user'=>$user
            
        ]);
    }
    /**
     * @Route("/{id}", name="app_experiences_show", methods={"GET"})
     */
    public function show(Experience $experience): Response
    {
        return $this->render('experiences/show.html.twig', [
            'experience' => $experience,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_experiences_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Experience $experience, ExperienceRepository $experienceRepository): Response
    {
        $form = $this->createForm(ExperienceFormType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $experienceRepository->add($experience, true);

            return $this->redirectToRoute('app_experiences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experiences/edit.html.twig', [
            'experience' => $experience,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_experiences_delete", methods={"POST"})
     */
    public function delete(Request $request, Experience $experience, ExperienceRepository $experienceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$experience->getId(), $request->request->get('_token'))) {
            $experienceRepository->remove($experience, true);
        }

        return $this->redirectToRoute('app_experiences_index', [], Response::HTTP_SEE_OTHER);
    }
}
