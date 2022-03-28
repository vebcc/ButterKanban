<?php


namespace App\Services\Task;


use App\Entity\Task;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TaskToIdTransformer implements DataTransformerInterface
{
    public function __construct
    (
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function transform($value): ?ArrayCollection
    {
        if ($value === null) {
            return null;
        }
        $tasks = new ArrayCollection();
        foreach ($value as $task) {
            if ($task === null) {
                $task = '';
            } else {
                $task = $task->getId();
            }
            $tasks->add($task);
        }
        return $tasks;
    }

    public function reverseTransform($value): ?ArrayCollection
    {
        if (!$value) {
            return null;
        }
        $tasks = new ArrayCollection();
        foreach ($value as $taskString) {
            $task = $this->entityManager->getRepository(Task::class)->find($taskString);

            if ($task === null) {
                throw new TransformationFailedException(sprintf(
                    'Task z id "%s" nie istnieje!',
                    $taskString
                ));
            }

            $tasks->add($task);
        }
        return $tasks;
    }
}