<?php


namespace App\Services\TaskQueue;


use App\Entity\TaskQueue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TaskQueueToIdTransformer implements DataTransformerInterface
{
    public function __construct
    (
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function transform($value): ?String
    {
        if ($value === null) {
            return null;
        }

        return (string)$value;
    }

    public function reverseTransform($value): ?ArrayCollection
    {
        if (!$value) {
            return null;
        }
            $taskQueue = $this->entityManager->getRepository(TaskQueue::class)->find($value);

            if ($taskQueue === null) {
                throw new TransformationFailedException(sprintf(
                    'Task z id "%s" nie istnieje!',
                    $value
                ));
            }
        return $taskQueue;
    }
}