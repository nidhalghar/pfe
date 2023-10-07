<?php

namespace App\Controller;

use App\Entity\Multimedia;
use App\Form\MultimediaType;
use App\Repository\MultimediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/multimedia")
 */
class MultimediaController extends AbstractController
{
    /**
     * @Route("/", name="app_multimedia_index", methods={"GET"})
     */
    public function index(MultimediaRepository $multimediaRepository): Response
    {
        return $this->render('multimedia/index.html.twig', [
            'multimedia' => $multimediaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_multimedia_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MultimediaRepository $multimediaRepository): Response
    {
        $multimedia = new Multimedia();
        $form = $this->createForm(MultimediaType::class, $multimedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $multimediaRepository->add($multimedia, true);

            return $this->redirectToRoute('app_multimedia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('multimedia/new.html.twig', [
            'multimedia' => $multimedia,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_multimedia_show", methods={"GET"})
     */
    public function show(Multimedia $multimedia): Response
    {
        return $this->render('multimedia/show.html.twig', [
            'multimedia' => $multimedia,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_multimedia_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Multimedia $multimedia, MultimediaRepository $multimediaRepository): Response
    {
        $form = $this->createForm(MultimediaType::class, $multimedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $multimediaRepository->add($multimedia, true);

            return $this->redirectToRoute('app_multimedia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('multimedia/edit.html.twig', [
            'multimedia' => $multimedia,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_multimedia_delete", methods={"POST"})
     */
    public function delete(Request $request, Multimedia $multimedia, MultimediaRepository $multimediaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$multimedia->getId(), $request->request->get('_token'))) {
            $multimediaRepository->remove($multimedia, true);
        }

        return $this->redirectToRoute('app_multimedia_index', [], Response::HTTP_SEE_OTHER);
    }
}
