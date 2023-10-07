<?php

namespace App\Controller;
use App\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Messages;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="app_messages")
     */
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
    /**
     * @Route("/messages", name="app_messages")
     */
    public function send(Request $request):Response
    {   
        
        $message = new Messages;
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());
            $em =$this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $this->addFlash("message", "Message envoyé avec succés.");
            return $this->redirectToRoute("app_messages");
        }
       
        return $this->render("messages/index.html.twig", [
          "form" => $form->createView()
        ]);
    }
     /**
     * @Route("/recevied", name="app_recevied")
     */
    public function recevied(): Response
    {
        return $this->render("messages/recevied.html.twig", [
            
        ]);
    }
      /**
     * @Route("/sent", name="app_sent")
     */
    public function sent(): Response
    {
        return $this->render("messages/sent.html.twig", [
            
        ]);
    }
     /**
     * @Route("/read/{id}", name="app_read")
     */
    public function read(Messages $message): Response
    {   
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        return $this->render("messages/read.html.twig", compact("message"));
    }
        /**
     * @Route("/delete/{id}", name="app_delete")
     */
    public function delete(Messages $message): Response
    {   
       
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();
        return $this->redirectToRoute("app_recevied");
    }
}
