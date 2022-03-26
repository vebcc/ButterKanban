<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $creationDate;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TaskUser::class, orphanRemoval: true)]
    private $taskUsers;

    #[ORM\ManyToOne(targetEntity: UserGroup::class, inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]
    private $userGroup;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TaskComment::class)]
    private $taskComments;

    public function __construct()
    {
        $this->taskUsers = new ArrayCollection();
        $this->taskComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection<int, TaskUser>
     */
    public function getTaskUsers(): Collection
    {
        return $this->taskUsers;
    }

    public function addTaskUser(TaskUser $taskUser): self
    {
        if (!$this->taskUsers->contains($taskUser)) {
            $this->taskUsers[] = $taskUser;
            $taskUser->setUser($this);
        }

        return $this;
    }

    public function removeTaskUser(TaskUser $taskUser): self
    {
        if ($this->taskUsers->removeElement($taskUser)) {
            // set the owning side to null (unless already changed)
            if ($taskUser->getUser() === $this) {
                $taskUser->setUser(null);
            }
        }

        return $this;
    }

    public function getUserGroup(): ?UserGroup
    {
        return $this->userGroup;
    }

    public function setUserGroup(?UserGroup $userGroup): self
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * @return Collection<int, TaskComment>
     */
    public function getTaskComments(): Collection
    {
        return $this->taskComments;
    }

    public function addTaskComment(TaskComment $taskComment): self
    {
        if (!$this->taskComments->contains($taskComment)) {
            $this->taskComments[] = $taskComment;
            $taskComment->setUser($this);
        }

        return $this;
    }

    public function removeTaskComment(TaskComment $taskComment): self
    {
        if ($this->taskComments->removeElement($taskComment)) {
            // set the owning side to null (unless already changed)
            if ($taskComment->getUser() === $this) {
                $taskComment->setUser(null);
            }
        }

        return $this;
    }
}
