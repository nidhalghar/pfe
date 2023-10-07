<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\PosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parametres;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function show(Request $request,UserRepository $userRepository, PosteRepository $posteRepository,MailerInterface $mailer ,EntityManagerInterface $manager): Response
    {
        $query = $request->query->get('u');
        $users = array();
        if ($query) {
            $keys = explode(" ",$query);
            foreach($keys as $key)
            array_push($users, $userRepository->search($key)); 
            /*$users = array_unique($users);*/
        } else {
            $users = null;
        }
        $user= $this->getUser(); 
        
            $message = new Contact;
            $form = $this->createForm(ContactType::class, $message);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $message->setSender($this->getUser());
                $em =$this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();            
          $this->addFlash(
            'success',
            'votre demande a été envoyer avec succés!'
          );
          return $this->redirectToRoute('app_home');
         
        }

        return $this->render('home/index.html.twig', [
            'users' => $users,
            'query' => $query,
            'user'=>$user,
            'postes' => $posteRepository->findAll(),
            'candidat' => $userRepository->findAll(),
            'formulaire' => $form->createView(),
        ]);
    }
  /**
     * @Route("/portfolio/{link}", name="app_portfolio_link") 
     */
    public function portfolio(Request $request, $link)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->findOneBy(["linkPublic" => $link]);
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $linkPublic = $request->getSchemeAndHttpHost() . '/' . $link;
        
        return $this->render('home/portfolio.html.twig', [
            'user' => $user,
            'linkPublic' => $linkPublic
        ]);
    }


}
    
    
    
    
    
    

  

    

