<?php


namespace App\Services\User;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserProvider
{
    private UserRepository $user;

    public function __construct
    (
        EntityManagerInterface $entityManager
    )
    {
        $this->user = $entityManager->getRepository(User::class);
    }

    public function getAllUsers(): array
    {
        return $this->user->findAll();
    }

    public function getUserByEmail(string $email): User
    {
        return $this->user->findOneBy(['email' => $email]);
    }
}