<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("najib.oulhouch@gmail.com");
        $user->setName("najib");
        $user->setPhone("0653804562");

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'najib'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
