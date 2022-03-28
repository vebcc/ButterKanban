<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskUserRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskUser:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskUser:list'],
            "access_control_message" => "You do not have the permission to post"
        ]
    ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskUser:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskUser:item'],
            "access_control_message" => "You do not have the permission to patch"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskUser:item'],
            "access_control_message" => "You do not have the permission to delete"
        ]
    ],
    paginationEnabled: false,
)]
class TaskUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['taskUser:list', 'taskUser:item'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'taskUsers')]
    #[Groups(['taskUser:list', 'taskUser:item'])]
    private $task;

    #[ORM\OneToMany(mappedBy: 'taskUser', targetEntity: TaskUserType::class)]
    #[Groups(['taskUser:list', 'taskUser:item'])]
    private $userType;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'taskUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['taskUser:list', 'taskUser:item'])]
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
