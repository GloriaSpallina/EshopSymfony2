<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use App\Data\SearchData;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Produit::class);
        $this->paginator = $paginator;
    }


     /**
     * @return Produit[]
     */

    public function findNew(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.dateAjoutProduit >= 01/01/2015')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findCheaper(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.prix <= 150')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function obtenirResultatsFiltres(SearchData $objFiltres)
    {
       
        $reqQB = $this->createQueryBuilder('produit');
             


        if (!empty($objFiltres->search)) {
            $reqQB = $reqQB->andWhere('produit.nom LIKE :search')
                ->setParameter('search', '%' . $objFiltres->search . '%'); // le LIKE a besoin de % %
        }
      
        if (!empty($objFiltres->minPrix)) {
            $reqQB = $reqQB->andWhere('produit.prix >= :minPrix')
                ->setParameter('minPrix', $objFiltres->minPrix);
        }

  


        $reqQBQuery = $reqQB->getQuery();
        return $this->paginator->paginate(
            $reqQBQuery,
            $objFiltres->numeroPage, 
            12
        );
    }



    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
