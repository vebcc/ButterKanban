<?php


namespace App\Services\UserGroup;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UserGroupCollectionDTO
{
    private Collection $userGroups;

    public function __construct(?array $userGroups = null)
    {
        $this->userGroups = new ArrayCollection($userGroups ?? []);
    }

    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function setUserGroups(Collection $userGroups): void
    {
        $this->userGroups = $userGroups;
    }

    public function toArray(): array
    {
        return $this->userGroups->toArray();
    }
}