<?php

namespace App\Controller;
use App\Entity\Education;
use App\Entity\Diplome;
use App\Form\DiplomeType;
use App\Repository\DiplomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/diplome")
 */
class DiplomeController extends AbstractController
{
    /**
     * @Route("/", name="app_diplome_index", methods={"GET"})
     */
    public function index(DiplomeRepository $diplomeRepository): Response
    {
        return $this->render('diplome/index.html.twig', [
            'diplomes' => $diplomeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_diplome_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DiplomeRepository $diplomeRepository): Response
    {
        $diplome = new Diplome();
        $form = $this->createForm(DiplomeType::class, $diplome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diplomeRepository->add($diplome, true);

            return $this->redirectToRoute('app_diplome_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diplome/new.html.twig', [
            'diplome' => $diplome,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_diplome_show", methods={"GET"})
     */
    public function show(Diplome $diplome): Response
    {
        return $this->render('diplome/show.html.twig', [
            'diplome' => $diplome,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_diplome_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Diplome $diplome, DiplomeRepository $diplomeRepository): Response
    {
        $form = $this->createForm(DiplomeType::class, $diplome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diplomeRepository->add($diplome, true);

            return $this->redirectToRoute('app_diplome_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diplome/edit.html.twig', [
            'diplome' => $diplome,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_diplome_delete", methods={"POST"})
     */
    public function delete(Request $request, Diplome $diplome, DiplomeRepository $diplomeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diplome->getId(), $request->request->get('_token'))) {
            $diplomeRepository->remove($diplome, true);
        }

        return $this->redirectToRoute('app_diplome_index', [], Response::HTTP_SEE_OTHER);
    }
}
