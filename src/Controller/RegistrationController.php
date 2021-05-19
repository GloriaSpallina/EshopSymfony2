<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Commande;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\FormulaireLoginAuthAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, FormulaireLoginAuthAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
            if ($this->getUser()) {

                /// ajouter une condition
                // aller en db voir si pour cette user il y a une commande avec status en cours
                // si pas en créer une.
                $objCommande = new Commande();
                $objCommande->setStatus('enCours');
                $objCommande->setDateCommande(new \DateTime(date('Y-m-d')));
                $em = $this->getDoctrine()->getManager();
                $em->persist($objCommande);
                
                $user = $this->getUser();
                $userAdLiv = $user->getAdresseLivraison();
                $objCommande->setAdresseLivraison($userAdLiv);
                $user->addCommande($objCommande);
                $em->persist($user);
                $em->flush();
    
                
    
                return $this->redirectToRoute('myaccount');
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
           
        ]);
    }
}
