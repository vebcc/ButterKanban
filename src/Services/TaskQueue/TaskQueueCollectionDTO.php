<?php

namespace App\Services\TaskQueue;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TaskQueueCollectionDTO
{
    private Collection $taskQueues;

    public function __construct(?array $taskQueues = null)
    {
        $this->taskQueues = new ArrayCollection($taskQueues ?? []);
    }

    public function getTaskQueues(): Collection
    {
        return $this->taskQueues;
    }

    public function setTaskQueues(Collection $taskQueues): void
    {
        $this->taskQueues = $taskQueues;
    }

    public function toArray(): array
    {
        return $this->taskQueues->toArray();
    }
}