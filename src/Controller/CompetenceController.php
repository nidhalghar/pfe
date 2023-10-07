<?php

namespace App\Controller;
use App\Entity\Competences;
use App\Form\CompetencesFormType;
use App\Repository\CompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/competence")
 */
class CompetenceController extends AbstractController
{
     /**
     * @Route("/", name="app_competences_index", methods={"GET"})
     */
    public function index(CompetencesRepository $competencesRepository): Response
    {
        return $this->render('competences/index.html.twig', [
            'competences' => $competencesRepository->findAll(),
        ]);
    }
    /**
      * @Route("/add", name="app_competence", methods={"GET","POST"})
     */
    public function addCompetence(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competence = new Competences();
        $user= $this->getUser();
        $form = $this->createForm(CompetencesFormType::class, $competence);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competence->setUser($user);
            $competence = $form->getData();
            $entityManager->persist($competence);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_competence');
        }

        return $this->render('competences/index1.html.twig', [
            'competencesForm' => $form->createView(),
            'user'=>$user
        ]);
    }
    /**
     * @Route("/{id}", name="app_competences_show", methods={"GET"})
     */
    public function show(Competences $competence): Response
    {
        return $this->render('competences/show.html.twig', [
            'competence' => $competence,
        ]);
        return redirectToRoute("app_competences_index");
    }

    /**
     * @Route("/{id}/edit", name="app_competences_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Competences $competence, CompetencesRepository $competencesRepository): Response
    {
        $form = $this->createForm(CompetencesFormType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competencesRepository->add($competence, true);

            return $this->redirectToRoute('app_competences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competences/edit.html.twig', [
            'competence' => $competence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_competences_delete", methods={"POST"})
     */
    public function delete(Request $request, Competences $competence, CompetencesRepository $competencesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competence->getId(), $request->request->get('_token'))) {
            $competencesRepository->remove($competence, true);
        }

        return $this->redirectToRoute('app_competences_index', [], Response::HTTP_SEE_OTHER);
    }
}
