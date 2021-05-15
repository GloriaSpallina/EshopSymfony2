<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProduitFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $produit = new Produit(['nom'=>$faker->randomElement($array = array ('Chaise','Table de salon','Tabouret','Divan','Bureau','Etagère','Miroir','Lampe','Rideaux','Meuble TV','Lit')) ." ". $faker->firstNameFemale,
                                    'prix'=>$faker->randomFloat($nbMaxDecimals = NULL, $min = 50, $max = 300),
                                    'couleur'=>$faker->safeColorName,
                                    'dateAjoutProduit'=>$faker->dateTime,
                                    'quantiteStock'=>$faker->numberBetween($min = 0, $max = 250),
                                    'description'=>$faker->realText($faker->numberBetween(150,200))]);
            
            $manager->persist($produit);
        }

        $manager->flush();
    }
}
