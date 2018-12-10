<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    private $dateInscription;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->dateInscription = new \DateTime('Europe/Paris');
    }
    public function load(ObjectManager $manager)
    {
        $membre = new User();
        $membre->setName("Louzet");
        $membre->setFirstname("Mickael");
        $membre->setEmail("micklouzet@hotmail.fr");
        $membre->setUsername("Irondev");
        $membre->setPassword($this->passwordEncoder->encodePassword($membre, '123456'));
        $membre->setDateInscription($this->dateInscription);
        $membre->setDerniereConnexion(null);

        $manager->persist($membre);
        $manager->flush();
    }
}
