<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10 ; $i++){
            $user = new User();
            $user->setEmail ("user".$i."@toto.com");
            $user->setPassword($this->passwordEncoder->encodePassword(
                 $user,
                 'mdp'.$i
             ));
            $user->setPrenom($faker->firstNameFemale,);
            $user->setNom($faker->lastName);
            $user->setDateNaissance($faker->dateTime);
            $user->setSexe('femme');
            $user->setTelephone($faker->PhoneNumber);


            $manager->persist ($user);
        }
        for ($i = 11; $i < 21 ; $i++){
            $user = new User();
            $user->setEmail ("user".$i."@toto.com");
            $user->setPassword($this->passwordEncoder->encodePassword(
                 $user,
                 'mdp'.$i
             ));
            $user->setPrenom($faker->firstNameMale,);
            $user->setNom($faker->lastName);
            $user->setDateNaissance($faker->dateTime);
            $user->setSexe('homme');
            $user->setTelephone($faker->phoneNumber);


            $manager->persist ($user);
        }
        $manager->flush();
    }
}