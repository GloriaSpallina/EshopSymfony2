<?php
namespace App\Data;

use App\Entity\SousCategorie;

// Classe pour representer les données de la recherche. Pas une entity, pas stockée dans la BD
class SearchData {


    public $numeroPage = 1; // la page du paginator à afficher (voir le paginator dans le repo)

    /**
     * La requête qu'on tape dans le form de recherche
     * @var string
     */
    public $search = '';

    
    /**
     * @var null|integer
     */
    public $minPrix; // durée minimal du film
    


    
}