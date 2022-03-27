<?php


namespace App\Services\TaskGroup;


use App\Entity\TaskGroup;
use App\Repository\TaskGroupRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskGroupProvider
{
    private TaskGroupRepository $taskGroup;

    public function __construct
    (
        EntityManagerInterface $entityManager
    )
    {
        $this->taskGroup = $entityManager->getRepository(TaskGroup::class);
    }

    public function getAllTasksGroupsWithTasks(): array
    {
        return $this->taskGroup->findAll();
    }
}