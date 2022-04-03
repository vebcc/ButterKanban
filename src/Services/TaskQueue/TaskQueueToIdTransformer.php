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
        dump($value);
        if ($value === null) {
            return null;
        }

        return (string)$value->getId();
    }

    public function reverseTransform($value): ?TaskQueue
    {
        dump($value);
        if (!$value) {
            return null;
        }
            $taskQueue = $this->entityManager->getRepository(TaskQueue::class)->find($value);

            if ($taskQueue === null) {
                throw new TransformationFailedException(sprintf(
                    'TaskQueue z id "%s" nie istnieje!',
                    $value
                ));
            }
        return $taskQueue;
    }
}