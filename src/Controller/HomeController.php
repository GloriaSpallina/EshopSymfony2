<?php

namespace App\Controller;


use App\Entity\Produit;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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

    #[Route("/cart", name: 'cart')]
    public function cart(): Response
    {
        return $this->render("home/cart.html.twig",[
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


}
