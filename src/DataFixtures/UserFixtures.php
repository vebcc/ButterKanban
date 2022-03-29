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
        $users = [
            ["vebcc", "Krzysiek", "vebcc08@gmail.com", 1, ["ROLE_ADMIN"], "maslohaslo132"],
            ["andrzej", "Andrzej", "andrzej@maslowski.it", 1, ["ROLE_USER"], "maslohaslo132"],
            ["janusz", "Janusz", "janusz@maslowski.it", 1, ["ROLE_USER"], "maslohaslo132"]
        ];

        foreach($users as $key => $value){
            $user = new User();
            $user->setName($value[1]);
            $user->setEmail($value[2]);
            $user->setIsVerified($value[3]);
            $user->setRoles($value[4]);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $value[5]));
            $manager->persist($user);
            $this->addReference("User_".$value[0], $user);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default', 'full'];
    }
}