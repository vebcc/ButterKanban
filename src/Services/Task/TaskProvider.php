<?php


namespace App\Services\Task;


use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskProvider
{
    private TaskRepository $task;

    public function __construct
    (
        EntityManagerInterface $entityManager
    )
    {
        $this->task = $entityManager->getRepository(Task::class);
    }

    public function getAllTasks(): array
    {
        return $this->task->findAll();
    }
}