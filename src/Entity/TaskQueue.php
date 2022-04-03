<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskQueueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskQueueRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskQueue:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskQueue:list'],
            "access_control_message" => "You do not have the permission to post"
        ]
        ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskQueue:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskQueue:item'],
            "access_control_message" => "You do not have the permission to patch"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskQueue:item'],
            "access_control_message" => "You do not have the permission to delete"
        ]
    ],
    paginationEnabled: false,
)]
class TaskQueue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['taskQueue:list', 'taskQueue:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['taskQueue:list', 'taskQueue:item'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['taskQueue:list', 'taskQueue:item'])]
    private $comment;

    #[ORM\Column(type: 'smallint')]
    #[Groups(['taskQueue:list', 'taskQueue:item'])]
    private $priority;

    #[ORM\OneToMany(mappedBy: 'queue', targetEntity: Task::class)]
    #[Groups(['taskQueue:list', 'taskQueue:item'])]
    private $tasks;

    #[ORM\OneToMany(mappedBy: 'oldQueue', targetEntity: Log::class)]
    private $logs;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getName();
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setQueue($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getQueue() === $this) {
                $task->setQueue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setOldQueue($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getOldQueue() === $this) {
                $log->setOldQueue(null);
            }
        }

        return $this;
    }
}
