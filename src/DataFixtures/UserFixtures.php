<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName("Krzysiek");
        $user->setEmail("vebcc08@gmail.com");
        $user->setIsVerified(1);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$pznwVzxqGMHI22BL8uQ7T.bjgrimx8lEZdkJ6/4Rgkxi8pXKEmeHq');
        $manager->persist($user);

        $manager->flush();
    }
}