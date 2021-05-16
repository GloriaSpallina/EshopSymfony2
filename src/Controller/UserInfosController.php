<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\ForulaireAdresseClType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

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
            return $this->render("user_adresse/traitement_formulaire_adresse.html.twig",
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
        
            return $this->render("user_adresse/traitement_formulaire_adresse.html.twig",
            ['adresse'=>$adresse]);
        }else{
            return $this->render("user_adresse/affichage_formulaire_adresse.html.twig",
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
        
            return $this->render("user_adresse/traitement_formulaire_adresse.html.twig",
            ['adresse'=>$adresse]);
        }else{
            return $this->render("user_adresse/affichage_formulaire_adresse.html.twig",
            ['formulaireAdresse'=>$formulaireAdresse->createView()]);
        }
    }
}
