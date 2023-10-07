<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
class AdminController extends AbstractController
{
     /**
     * @Route("/admin", name="app_admin")
     */
    public function recevied(EntityManagerInterface $entityManager): Response
    {
        $messag = $entityManager->getRepository(Contact::class)->findAll(); // Récupérer tous les messages envoyés

        return $this->render("admin/index.html.twig", [
            'messag' => $messag
        ]);
    }
     /**
 * @Route("/read/{id}", name="app_rea")
 */
public function read(Contact $message): Response
{   
    $em = $this->getDoctrine()->getManager();
    $em->persist($message);
    $em->flush();
    return $this->render("admin/read.html.twig", compact("message"));
}
        /**
     * @Route("/delete/{id}", name="app_delet")
     */
    public function delete(Contact $contact): Response
    {   
       
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        return $this->redirectToRoute("app_admin");
    }
    

}
