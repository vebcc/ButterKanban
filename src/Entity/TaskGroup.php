<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskGroupRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskGroup:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskGroup:list'],
            "access_control_message" => "You do not have the permission to post"
        ]
    ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskGroup:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskGroup:item'],
            "access_control_message" => "You do not have the permission to patch"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_USER')" ,
            'normalization_context' => ['groups' => 'taskGroup:item'],
            "access_control_message" => "You do not have the permission to delete"
        ]
    ],
    paginationEnabled: false,
)]
class TaskGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['taskGroup:list', 'taskGroup:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['taskGroup:list', 'taskGroup:item'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['taskGroup:list', 'taskGroup:item'])]
    private $comment;

    #[ORM\OneToMany(mappedBy: 'taskGroup', targetEntity: Task::class, orphanRemoval: true)]
    #[Groups(['taskGroup:list', 'taskGroup:item'])]
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
            $task->setTaskGroup($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getTaskGroup() === $this) {
                $task->setTaskGroup(null);
            }
        }

        return $this;
    }
}
