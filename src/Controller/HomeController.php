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
use App\Entity\Evaluation;
use App\Form\ForulaireAdresseClType;
use App\Repository\DetailCommandeRepository;
use SessionIdInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route("/", name: 'index')]
    public function index(ProduitRepository $pr): Response
    {
        return $this->render("home/index.html.twig",[
            'NewProduits'=>$pr->findNew(),
            'Cheapest'=>$pr->findCheaper()
        ]);
    }

    #[Route("/product/list", name: 'productlist')]
    public function productlist(ProduitRepository $produitRepository): Response
    {
        return $this->render("home/product-list.html.twig",[
            'produits'=>$produitRepository->findAll()
        ]);
    }

    #[Route("/product/{id}/detail", name: 'productdetail')]
    public function productDetail(Produit $produit, Request $req): Response
    {
        if($this->getUser()){
            $idProduit= $req->get('id');
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $rep = $em->getRepository(Commande::class);
            $commandeValidees = $rep->findBy([
                'status'=>'valide',
                'user' => $user
            ]);
            
            if ($commandeValidees) {
                foreach ($commandeValidees as $value) {
                    $idDerniereCommande = $value->getId();
                }
                $rep1 = $em->getRepository(DetailCommande::class);
                $isCommande = $rep1->findBy([
                    'commandeRef'=> $idDerniereCommande,
                    'produit'=>$idProduit
                ]);

                $reviews = $produit->getEvaluations();
            

                if($isCommande){
                    return $this->render("home/product-detail.html.twig", [
                        'produit'=>$produit,
                        'isCommande'=>true,
                        'reviews'=>$reviews
                    ]);
                }else{
                    return $this->render("home/product-detail.html.twig", [
                        'produit'=>$produit,
                        'isCommande'=>false,
                        'reviews'=>$reviews
                    ]);
                }
                
            }
           


          

            
        }
      
        $reviews = $produit->getEvaluations();
       

        return $this->render("home/product-detail.html.twig", [
            'produit'=>$produit,
            'isCommande'=>false,
            'reviews'=>$reviews
        ]);
    }


    #[Route("/checkout", name: 'checkout')]
    public function checkout(): Response
    {
        
        $adresseLivraisonUser = $this->getUser()->getAdresseLivraison();
        $adresseUser = $this->getUser()->getAdresse();
        

        if (!$adresseUser) {
            return $this->redirectToRoute('user_adresse',
            ['messageErreur'=> "Veuillez remplir vos coordonnées"]);
        }
        if (!$adresseLivraisonUser) {
            return $this->redirectToRoute('user_adresse_livraison',
            ['messageErreur'=> "Veuillez remplir vos coordonnées"]);
        }

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

        $totalCommande = $cec->getTotal();
        return $this->render("home/checkout.html.twig",
        ['adresseLivraison'=>$adresseLivraisonUser,
        'adresse'=>$adresseUser,
        'panier'=>$panier,
        'total'=>$totalCommande
        ]
        
    );
    }

    #[Route("/myaccount", name: 'myaccount')]
    public function myaccount(): Response
    {
        return $this->render("home/my-account.html.twig");
    }



    #[Route("/contact", name: 'contact')]
    public function contact(): Response
    {
        return $this->render("home/contact.html.twig");
    }

    #[Route("/cart", name: 'cart')]
    public function cart(): Response
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
        
        if($cec){
            $totalCommande = $cec->getTotal();
        }
        

        return $this->render("home/cart.html.twig",
            ['panier'=>$panier,
            'total'=>$totalCommande]
        );
    }

    #[Route("/cart/remove/product/{id}", name: 'removeProduitPanier')]
    public function cartRemoveProduct(Request $req): Response
    {
        $idDetailCommande = $req->get('id');

        $em = $this->getDoctrine()->getManager();
        $detailCommande = $em->getRepository(DetailCommande::class)->find($idDetailCommande);

        $em->remove($detailCommande);
        $em->flush();

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
        
        if($cec){
            $totalCommande = $cec->getTotal();
        }

        return $this->render("home/cart.html.twig",
        ['panier'=>$panier,
        'total'=>$totalCommande]
    );
    }

    
    #[Route("/add/to/cart/{id}", name: 'addToCart')]
    public function AddToCart(Request $req): Response
    {
        $em = $this->getDoctrine()->getManager();

        $idProduit = $req->get('id');
        $rep = $em->getRepository(Produit::class);
        $produit = $rep->find($idProduit);

        $quantiteRecup = $req->get('quantite');
        if($quantiteRecup != null && $quantiteRecup > 0){
            $quantiteVoulue = $quantiteRecup;
        }else{
            $quantiteVoulue = 1;
        }
       
        $user = $this->getUser();
        $rep1 = $em->getRepository(Commande::class);
        $cec = $rep1->findOneBy([
            'status'=>'enCours',
            'user' => $user
        ]);

        //$id = $cec->getId();

        $dc = new DetailCommande();
        $dc->setQuantite($quantiteVoulue);
        $dc->setProduit($produit);
        $dc->setCommandeRef($cec);
        
        $isDoublon = $em->getRepository(DetailCommande::class)->findOneBy([
            'produit'=>$produit,
            'commandeRef'=>$cec
        ]);

        if($isDoublon){
            $isDoublon->setQuantite($quantiteVoulue);
            $em->persist($isDoublon);
            $em->flush();
        }else{
            $em->persist($dc);
            $em->flush();

        }
        
        return $this->redirectToRoute("productlist");
        
    }

    #[Route("/OrderValid", name: 'place_order')]
    public function placeOrder(): Response
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(Commande::class);
        $cec = $rep->findOneBy([
            'status'=>'enCours',
            'user' => $user
        ]);
        $cec->setStatus('valide');

        $em->flush();
        $this->addFlash('success','Commande validée!');
        return $this->render("home/index.html.twig");
    }

    #[Route("/add/review/{id}", name: 'add_review')]
    public function addRiew(Request $req, Produit $p): Response
    {
        $idProduit = $req->get('id');
        $commentaire = $req->get('review');
        $note = $req->get('note');
        $user = $this->getUser();

        $review = new Evaluation();
        $review->setCommentaire($commentaire);
        $review->setNote($note);
        $review->setStatus('valide'); // mettre false et dois être validé par admin
        $review->setDateEvaluation(new \DateTime(date('Y-m-d')));
        $review->setProduit($p);
        $review->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($review);
        $em->flush();

        return $this->redirectToRoute("productlist");
    }

}
