<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskCommentRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskComment:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskComment:list'],
            "access_control_message" => "You do not have the permission to post"
        ]
    ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskComment:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskComment:item'],
            "access_control_message" => "You do not have the permission to patch"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskComment:item'],
            "access_control_message" => "You do not have the permission to delete"
        ]
    ],
    paginationEnabled: false,
)]
class TaskComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['taskComment:list', 'taskComment:item'])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['taskComment:list', 'taskComment:item'])]
    private $comment;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['taskComment:list', 'taskComment:item'])]
    private $date;

    #[ORM\Column(type: 'smallint')]
    #[Groups(['taskComment:list', 'taskComment:item'])]
    private $type;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'taskComments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['taskComment:list', 'taskComment:item'])]
    private $task;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'taskComments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['taskComment:list', 'taskComment:item'])]
    private $user;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
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
}
