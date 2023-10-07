<?php

namespace App\Controller;
use App\Repository\CertificatRepository;
use App\Entity\Certificat;
use App\Form\CertificatFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/certificat")
 */
class CertificationController extends AbstractController
{
     /**
     * @Route("/", name="app_certificat_index", methods={"GET"})
     */
    public function index(CertificatRepository $certificatRepository): Response
    {
        return $this->render('certificat/index.html.twig', [
            'certificats' => $certificatRepository->findAll(),
        ]);
    }

    

    /**
     * @Route("/{id}/show", name="app_certificat_show", methods={"GET"})
     */
    public function show(Certificat $certificat): Response
    {
        
        return $this->render('certificat/show.html.twig', [
            'certificat' => $certificat,
        ]);
         return redirectToRoute("app_certificat_index");
    }

    /**
     * @Route("/{id}/edit", name="app_certificat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
      
        $form = $this->createForm(CertificatFormType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificatRepository->add($certificat, true);

            return $this->redirectToRoute('app_certificat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/edit.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_certificat_delete", methods={"POST"})
     */
    public function delete(Request $request, Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certificat->getId(), $request->request->get('_token'))) {
            $certificatRepository->remove($certificat, true);
        }

        return $this->redirectToRoute('app_certificat_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
      * @Route("/add", name="app_certification", methods={"GET","POST"})
     */
    public function addCertificat(Request $request, EntityManagerInterface $entityManager): Response
    {
        $certificat = new Certificat();
        $user= $this->getUser();
        $form = $this->createForm(CertificatFormType::class, $certificat);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificat->setUser($user);
            $certificat = $form->getData();
            $entityManager->persist($certificat);
            $entityManager->flush();

            return $this->redirectToRoute('app_certification');
        }

        return $this->render('certificat/index1.html.twig', [
            'certificatForm' => $form->createView(),
            'user'=>$user
        ]);
    }
}