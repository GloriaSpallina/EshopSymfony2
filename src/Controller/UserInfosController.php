<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\AdresseLivraison;
use App\Entity\CarteBancaire;
use App\Form\ForulaireAdresseClType;
use App\Form\FormAdresseLivraisonClType;
use App\Form\FormCarteBancaireClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserInfosController extends AbstractController
{
    #[Route('/user/adresse', name: 'user_adresse')]
    public function addAdresse(Request $req): Response
    {
        $adresse = new Adresse();
        $formulaireAdresse = $this->createForm(ForulaireAdresseClType::class, $adresse,
        ['action'=>$this->generateUrl("user_adresse"),
        'method'=>'POST']);

        $formulaireAdresse->handleRequest($req);

        $CurrentUser = $this->getUser();
        $adresseCurrentUser = $CurrentUser->getAdresse();
        if($adresseCurrentUser !== null){
            return $this->render("user_infos/traitement_formulaire_adresse.html.twig",
            ['adresse'=>$adresseCurrentUser]);
        }
        elseif($formulaireAdresse->isSubmitted() && $formulaireAdresse->isValid()){
            // Il faut encore vérifier si l'adresse est déjà en DB 
            //si oui, il ne faut pas créer une nouvelle
            //Récupérer l'id et l'attribuer à l'user !
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();
            $user = $this->getUser();
            $user->setAdresse($adresse);
            $em->persist($user);
            $em->flush();
        
            return $this->render("user_infos/traitement_formulaire_adresse.html.twig",
            ['adresse'=>$adresse]);
        }else{
            return $this->render("user_infos/affichage_formulaire_adresse.html.twig",
            ['formulaireAdresse'=>$formulaireAdresse->createView()]);
        }
       
    }

    #[Route('/user/adresseUptade', name: 'user_adresse_update')]
    public function updateAdresse(Request $req): Response
    {
        // Je créer une autre adresse car comme ça on garde en DB même les anciennes adresse
        // p-e qu'elle sera attribuée à une autre personne avc la vérif que j'ai pas encore codée ^^
        $adresse = new Adresse();
        $formulaireAdresse = $this->createForm(ForulaireAdresseClType::class, $adresse,
        ['action'=>$this->generateUrl("user_adresse_update"),
        'method'=>'POST']);
        $formulaireAdresse->handleRequest($req);

        if($formulaireAdresse->isSubmitted() && $formulaireAdresse->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();
            $user = $this->getUser();
            $user->setAdresse($adresse);
            $em->persist($user);
            $em->flush();
        
            return $this->render("user_infos/traitement_formulaire_adresse.html.twig",
            ['adresse'=>$adresse]);
        }else{
            return $this->render("user_infos/affichage_formulaire_adresse.html.twig",
            ['formulaireAdresse'=>$formulaireAdresse->createView()]);
        }
    }

    #[Route('/user/adresseLivraison', name: 'user_adresse_livraison')]
    public function addAdresseLivraison(Request $req): Response
    {
        $adresseLivraison = new AdresseLivraison();
        $formulaireAdresseLivraison = $this->createForm(FormAdresseLivraisonClType::class, $adresseLivraison,
        ['action'=>$this->generateUrl("user_adresse_livraison"),
        'method'=>'POST']);

        $formulaireAdresseLivraison->handleRequest($req);

        $CurrentUser = $this->getUser();
        $adresseLivraisonCurrentUser = $CurrentUser->getAdresseLivraison();
        if($adresseLivraisonCurrentUser !== null){
            return $this->render("user_infos/traitement_formulaire_adresse_livraison.html.twig",
            ['adresse'=>$adresseLivraisonCurrentUser]);
        }
        elseif($formulaireAdresseLivraison->isSubmitted() && $formulaireAdresseLivraison->isValid()){
            // Il faut encore vérifier si l'adresse est déjà en DB 
            //si oui, il ne faut pas créer une nouvelle
            //Récupérer l'id et l'attribuer à l'user !
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresseLivraison);
            $em->flush();
            $user = $this->getUser();
            $user->setAdresseLivraison($adresseLivraison);
            $em->persist($user);
            $em->flush();
        
            return $this->render("user_infos/traitement_formulaire_adresse_livraison.html.twig",
            ['adresseLivraison'=>$adresseLivraison]);
        }else{
            return $this->render("user_infos/affichage_formulaire_adresse_livraison.html.twig",
            ['formulaireAdresseLivraison'=>$formulaireAdresseLivraison->createView()]);
        }
       
    }

    #[Route('/user/adresseLivraisonUptade', name: 'user_adresse_livraison_update')]
    public function updateAdresseLivraison(Request $req): Response
    {
        // Je créer une autre adresse car comme ça on garde en DB même les anciennes adresse
        // p-e qu'elle sera attribuée à une autre personne avc la vérif que j'ai pas encore codée ^^
        $adresseLivraison = new AdresseLivraison();
        $formulaireAdresseLivraison = $this->createForm(FormAdresseLivraisonClType::class, $adresseLivraison,
        ['action'=>$this->generateUrl("user_adresse_livraison_update"),
        'method'=>'POST']);
        $formulaireAdresseLivraison->handleRequest($req);

        if($formulaireAdresseLivraison->isSubmitted() && $formulaireAdresseLivraison->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresseLivraison);
            $em->flush();
            $user = $this->getUser();
            $user->setAdresseLivraison($adresseLivraison);
            $em->persist($user);
            $em->flush();
        
            return $this->render("user_infos/traitement_formulaire_adresse_livraison.html.twig",
            ['adresseLivraison'=>$adresseLivraison]);
        }else{
            return $this->render("user_infos/affichage_formulaire_adresse_livraison.html.twig",
            ['formulaireAdresse'=>$formulaireAdresseLivraison->createView()]);
        }
    }

    #[Route('/user/carteBancaire', name: 'user_carte_bancaire')]
    public function addCarteBancaire(Request $req): Response
    {
        $carteBancaire = new CarteBancaire();
        $formulaireCarteBancaire = $this->createForm(FormCarteBancaireClientType::class, $carteBancaire,
        ['action'=>$this->generateUrl("user_carte_bancaire"),
        'method'=>'POST']);

        $formulaireCarteBancaire->handleRequest($req);

        $cartes = $this->getUser()->getCartes();
        if (!$cartes) {
            return $this->render("user_infos/traitement_formulaire_carte_bancaire.html.twig",
            ['cartes'=>$cartes]);

        }
       elseif($formulaireCarteBancaire->isSubmitted() && $formulaireCarteBancaire->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($carteBancaire);
            $em->flush();
            $user = $this->getUser();
            $user->addCarte($carteBancaire);
            $em->persist($user);
            $em->flush();
            $cartes = $this->getUser()->getCartes();
            return $this->render("user_infos/traitement_formulaire_carte_bancaire.html.twig",
            ['cartes'=>$cartes]);
        }else{
            return $this->render("user_infos/affichage_formulaire_carte_bancaire.html.twig",
            ['formulaireCarteBancaire'=>$formulaireCarteBancaire->createView()]);
        }
    
    }

    #[Route('/user/cbRemove/{id}', name: 'user_cb_remove')]
    public function carteBancaireRemove(Request $req): Response
    {
        $id = $req->get('id');

        $em = $this->getDoctrine()->getManager();
        $laCarte = $em->getRepository(CarteBancaire::class)->findOneBy(array("id"=> $id));
        $em->remove($laCarte);
        $em->flush();

        $this->addFlash('success','Carte supprimée !');

        return $this->render("home/my-account.html.twig");
       
    }




}
