<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, SessionInterface $si): Response
    {
        if ($this->getUser()) {

           
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

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
