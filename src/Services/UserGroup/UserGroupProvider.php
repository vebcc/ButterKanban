<?php


namespace App\Services\UserGroup;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserGroup;

class UserGroupProvider
{
    private $userGroups;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->userGroups = $entityManager->getRepository(UserGroup::class);
    }

    public function getUserGroupByName(string $name): ?UserGroup
    {
        return $this->userGroups->findOneBy(['name' => $name]);
    }
}