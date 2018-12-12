<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Behat\Transliterator\Transliterator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $passwordEncoder;

    private $dateInscription;

    private $container;

    private $roles = [];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ContainerInterface $container)
    {
        $this->passwordEncoder = $passwordEncoder;

        $this->dateInscription = new \DateTime('Europe/Paris');

        $this->container = $container;

        $this->roles = ["ROLE_GERANT", "ROLE_ADMIN", "ROLE_SUPER_ADMIN"];


    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=0; $i<4; $i++)
        {
            $user = new User();

            $user->setName($faker->name());
            $user->setFirstname($faker->firstName());
            $user->setUsername($faker->userName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 123456));
            $user->setDateInscription($faker->dateTimeThisYear);
            $user->setDerniereConnexion(null);
            $user->setRoles([$this->roles[array_rand($this->roles, 1)]]);

            $manager->persist($user);

        }

        $manager->flush();
    }
}
