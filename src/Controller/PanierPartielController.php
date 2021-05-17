<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierPartielController extends AbstractController
{
    public function panierDynamique()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
       
        $rep1 = $em->getRepository(Commande::class);
        $cec = $rep1->findOneBy([
            'status'=>'enCours',
            'user' => $user
        ]);

       
        $rep = $em->getRepository(DetailCommande::class);
        $panier = $rep->findBy([
            'commandeRef'=>$cec,
        ]);

        return $this->render('panier_partiel/cartDynamique.html.twig', ['panier' => $panier]);
    }
}

 