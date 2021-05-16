<?php

namespace App\Controller;


use App\Entity\Produit;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Form\ForulaireAdresseClType;
use SessionIdInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route("/", name: 'index')]
    public function index(): Response
    {
        return $this->render("home/index.html.twig");
    }

    #[Route("/product/list", name: 'productlist')]
    public function productlist(ProduitRepository $produitRepository): Response
    {
        return $this->render("home/product-list.html.twig",[
            'produits'=>$produitRepository->findAll()
        ]);
    }

    #[Route("/product/{id}/detail", name: 'productdetail')]
    public function productDetail(Produit $produit): Response
    {
        return $this->render("home/product-detail.html.twig", [
            'produit'=>$produit,
        ]);
    }


    #[Route("/checkout", name: 'checkout')]
    public function checkout(): Response
    {
        return $this->render("home/checkout.html.twig");
    }

    #[Route("/myaccount", name: 'myaccount')]
    public function myaccount(): Response
    {

        return $this->render("home/my-account.html.twig");
    }


    #[Route("/wishlist", name: 'wishlist')]
    public function wishlist(): Response
    {
        return $this->render("home/wishlist.html.twig");
    }

    #[Route("/contact", name: 'contact')]
    public function contact(): Response
    {
        return $this->render("home/contact.html.twig");
    }

    #[Route("/cart", name: 'cart')]
    public function cart(): Response
    {
        return $this->render("home/cart.html.twig",[
        ]);
    }

    #[Route("/add/to/cart/{id}", name: 'addToCart')]
    public function AddToCart(Request $req, SessionInterface $si): Response
    {
        $idProduit = $req->get('id');

        $quantiteRecup = $req->get('quantite');
        if($quantiteRecup != null){
            $quantiteVoulue = $quantiteRecup;
        }else{
            $quantiteVoulue = 1;
        }

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(Produit::class);
        $produit = $rep->find($idProduit);
        $dc = new DetailCommande();
        $dc->setQuantite($quantiteVoulue);
        $dc->setProduit($produit);
        //$commande = new Commande();
        //Aller chercher en DB une commande 'en cours'
        // dans le security manager, aller chercher une commande en cours et la mettre en session
        // ou créer une nouvelle commande en cours + setStatu'en cours'
        // mettre dans une variable l'objets qui est en session.
        //addDetailCommande
        // pour afficher faire comme CB.
        // $commande->setStatus('enCours');
        // $commande->addDetailsCommande($dc);
        // $user = $this->getUser();
        // $user->addCommande($commande);
        // $commandes = $this->getUser()->getCommandes();
        
        // $user = $this->getUser();
        // $commandeU = $user->getCommandes();
        // $this->getUser()->getCommandes();
        // $commandeU->addDetailsCommande($dc);
        // $cm = $si->get('panier');
        // $cm->addDetailsCommande($dc);
        
        // $em2=$this->getDoctrine()->getManager();
        // $em2->persist($cm);
        // $em2->flush($cm);
        // $user = $this->getUser();
        // $adresseLi = $user->getAdresseLivraison();
        // $em2->persist($user)

        // $alo = $si->get('panier');
        // //dd($cm);
        // dd($commandeU);

        // ['commandes'=>$commandes]
        
        return $this->render("home/test.html.twig"
        );
    }


}
