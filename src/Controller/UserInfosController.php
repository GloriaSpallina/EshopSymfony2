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
    #[Route('/user/infos', name: 'user_infos')]
    public function addAdresse(Request $req, Security $security): Response
    {
        $adresse = new Adresse();
        $formulaireAdresse = $this->createForm(ForulaireAdresseClType::class, $adresse,
        ['action'=>$this->generateUrl("user_infos"),
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
}
