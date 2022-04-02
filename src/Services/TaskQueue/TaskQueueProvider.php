<?php


namespace App\Services\TaskQueue;


use App\Entity\TaskQueue;
use App\Repository\TaskQueueRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskQueueProvider
{
    private TaskQueueRepository $taskQueue;

    public function __construct
    (
        EntityManagerInterface $entityManager
    )
    {
        $this->taskQueue = $entityManager->getRepository(TaskQueue::class);
    }

    public function getAllTaskQueues(): array
    {
        return $this->taskQueue->findAll();
    }

    public function getAllTasksQueuesWithTasks(): array
    {
        return $this->taskQueue->findAllTaskQueuesWithTasks();
    }

    public function getAllTasksQueuesDTOWithTasks(): TaskQueueCollectionDTO
    {
        return new TaskQueueCollectionDTO($this->taskQueue->findAllTaskQueuesWithTasks());
    }

    public function getTaskByName(string $name): TaskQueue
    {
        return $this->taskQueue->findOneBy(['name' => $name]);
    }
}