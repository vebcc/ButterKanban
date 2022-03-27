<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName("Krzysiek");
        $user->setEmail("vebcc08@gmail.com");
        $user->setIsVerified(1);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'maslohaslo132'));
        $manager->persist($user);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default', 'full'];
    }
}