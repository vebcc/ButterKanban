<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
#[ApiResource]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: task::class, inversedBy: 'logs')]
    #[ORM\JoinColumn(nullable: false)]
    private $task;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'logs')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: TaskComment::class, inversedBy: 'logs')]
    private $comment;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $value;

    #[ORM\ManyToOne(targetEntity: TaskQueue::class, inversedBy: 'logs')]
    private $oldQueue;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getComment(): ?TaskComment
    {
        return $this->comment;
    }

    public function setComment(?TaskComment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getOldQueue(): ?TaskQueue
    {
        return $this->oldQueue;
    }

    public function setOldQueue(?TaskQueue $oldQueue): self
    {
        $this->oldQueue = $oldQueue;

        return $this;
    }
}
