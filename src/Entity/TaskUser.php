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

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'taskUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['taskUser:list', 'taskUser:item'])]
    private $user;

    #[ORM\ManyToOne(targetEntity: TaskUserType::class, inversedBy: 'taskUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private $taskUserType;

    public function __construct()
    {
        $this->userType = new ArrayCollection();
    }
    public function __toString(): string
    {
        return (string)$this->getId();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTaskUserType(): ?TaskUserType
    {
        return $this->taskUserType;
    }

    public function setTaskUserType(?TaskUserType $taskUserType): self
    {
        $this->taskUserType = $taskUserType;

        return $this;
    }
}
