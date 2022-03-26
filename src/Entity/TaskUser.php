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

    #[ORM\ManyToOne(targetEntity: task::class, inversedBy: 'taskUsers')]
    private $task;

    #[ORM\OneToMany(mappedBy: 'taskUser', targetEntity: taskUserType::class)]
    private $userType;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'taskUsers')]
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

    public function getTask(): ?task
    {
        return $this->task;
    }

    public function setTask(?task $task): self
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return Collection<int, taskUserType>
     */
    public function getUserType(): Collection
    {
        return $this->userType;
    }

    public function addUserType(taskUserType $userType): self
    {
        if (!$this->userType->contains($userType)) {
            $this->userType[] = $userType;
            $userType->setTaskUser($this);
        }

        return $this;
    }

    public function removeUserType(taskUserType $userType): self
    {
        if ($this->userType->removeElement($userType)) {
            // set the owning side to null (unless already changed)
            if ($userType->getTaskUser() === $this) {
                $userType->setTaskUser(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
