<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'task:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'task:list'],
            "access_control_message" => "You do not have the permission to get"
        ]
        ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'task:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'task:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'task:item'],
            "access_control_message" => "You do not have the permission to get"
        ]
    ],

    order: ['startData' => 'DESC'],
    paginationEnabled: false,
)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['task:list', 'task:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    #[Groups(['task:list', 'task:item'])]
    private $tittle;

    #[ORM\Column(type: 'text')]
    #[Groups(['task:list', 'task:item'])]
    private $comment;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['task:list', 'task:item'])]
    private $startData;

    #[ORM\ManyToOne(targetEntity: TaskGroup::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private $taskGroup;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: TaskUser::class)]
    private $taskUsers;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: TaskComment::class, orphanRemoval: true)]
    private $taskComments;

    #[ORM\ManyToOne(targetEntity: TaskQueue::class, inversedBy: 'tasks')]
    #[Groups(['task:list', 'task:item'])]
    #[ORM\JoinColumn(nullable: false)]
    private $queue;

    public function __construct()
    {
        $this->taskUsers = new ArrayCollection();
        $this->taskComments = new ArrayCollection();
        $this->startData = new \DateTime();
    }

    public function __toString(): string
    {
        return (string)$this->getTittle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTittle(): ?string
    {
        return $this->tittle;
    }

    public function setTittle(string $tittle): self
    {
        $this->tittle = $tittle;

        return $this;
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

    public function getStartData(): ?\DateTimeInterface
    {
        return $this->startData;
    }

    public function setStartData(\DateTimeInterface $startData): self
    {
        $this->startData = $startData;

        return $this;
    }

    public function getTaskGroup(): ?TaskGroup
    {
        return $this->taskGroup;
    }

    public function setTaskGroup(?TaskGroup $taskGroup): self
    {
        $this->taskGroup = $taskGroup;

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
            $taskUser->setTask($this);
        }

        return $this;
    }

    public function removeTaskUser(TaskUser $taskUser): self
    {
        if ($this->taskUsers->removeElement($taskUser)) {
            // set the owning side to null (unless already changed)
            if ($taskUser->getTask() === $this) {
                $taskUser->setTask(null);
            }
        }

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
            $taskComment->setTask($this);
        }

        return $this;
    }

    public function removeTaskComment(TaskComment $taskComment): self
    {
        if ($this->taskComments->removeElement($taskComment)) {
            // set the owning side to null (unless already changed)
            if ($taskComment->getTask() === $this) {
                $taskComment->setTask(null);
            }
        }

        return $this;
    }

    public function getQueue(): ?TaskQueue
    {
        return $this->queue;
    }

    public function setQueue(?TaskQueue $queue): self
    {
        $this->queue = $queue;

        return $this;
    }
}
