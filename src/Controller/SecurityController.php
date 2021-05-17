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

            // $si->set('panier', $objCommande);
            // $commandeEnCOurs = $si->get('panier');
            // dd($commandeEnCOurs);
            //aller chercher en session si isPanier = null
            //$isPanier = $si->get('isPanier');
            // $objCommande = new Commande();
            // $objCommande->setStatus('enCours');
            // $si->set('panier', $objCommande);
            // si isPanier est false alors Créer un objet Commande, le stocker dans la session (clé panier)
            // if($isPanier == null){
                
            //     $objCommande = new Commande();
            //     $objCommande->setStatus('enCours');
            //     $si->set('isPanier', 'true');
            //     $si->set('panier', $objCommande);
            //     $si->set('test', 'toto');

                
            // }else{
            //     // si c'est true -> Obtenir le contenu de l'objet commande qui est notre panier.
            //     $objCommandeEnAttente = $si->get('panier');
            //     // le renvoyer vers où on veut.
            // }
            

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
