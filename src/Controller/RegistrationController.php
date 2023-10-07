<?php

namespace App\Controller;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\User;
use App\Entity\Parametres;
use App\Form\RegistrationFormType;
use App\Form\RegistreType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class RegistrationController extends AbstractController
{    
    /**
     * @Route("/register", name="app_register")
     */
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
     /**
     * @Route("/registerRec", name="app_register_recruteur")
     */
    public function registerRecruteur(Request $request, UserPasswordHasherInterface $userPasswordHasher,SluggerInterface $slugger, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistreType::class, $user);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $imageFile = $form->get('photo')->getData();
            if ($imageFile )
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension(); 
                // Move the file to the directory where images are stored
                try 
                { 
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                }catch(FileException $e){}
            }
            // Save the image file path to your database
            $user->setImage  ("uploads/photoProfil/".($newFilename));
            
                
          
                $user->setRoles(['ROLE_RECRUTEUR']);
            
            
            $entityManager->persist($user);
            $entityManager->flush();   
        }
        return $userAuthenticator->authenticateUser(
            $user,
            $authenticator,
            $request
        );
        }

        return $this->render('registration/socitie.html.twig', [
            'registreForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/registercan", name="app_register_candidat")
     */
     public function registerCandidat(Request $request, UserPasswordHasherInterface $userPasswordHasher,SluggerInterface $slugger, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
        {
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
           
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $imageFile = $form->get('photo')->getData();
                if ($imageFile )
                {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension(); 
                    // Move the file to the directory where images are stored
                    try 
                    { 
                        $imageFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    }catch(FileException $e){}
                }
                // Save the image file path to your database
                $user->setImage  ("uploads/photoProfil/".($newFilename));
                
                    
              
                    $user->setRoles(['ROLE_CANDIDAT']);
                
                
                $entityManager->persist($user);
                $entityManager->flush();   
            }
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            }
    
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }
    
       
    

}