<?php

namespace App\Entity;

use App\Repository\TaskUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskUserRepository::class)]
class TaskUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'taskUsers')]
    private $task;

    #[ORM\OneToMany(mappedBy: 'taskUser', targetEntity: TaskUserType::class)]
    private $userType;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'taskUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function __construct()
    {
        $this->userType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return Collection<int, TaskUserType>
     */
    public function getUserType(): Collection
    {
        return $this->userType;
    }

    public function addUserType(TaskUserType $userType): self
    {
        if (!$this->userType->contains($userType)) {
            $this->userType[] = $userType;
            $userType->setTaskUser($this);
        }

        return $this;
    }

    public function removeUserType(TaskUserType $userType): self
    {
        if ($this->userType->removeElement($userType)) {
            // set the owning side to null (unless already changed)
            if ($userType->getTaskUser() === $this) {
                $userType->setTaskUser(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
