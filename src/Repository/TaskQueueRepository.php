<?php

namespace App\Repository;

use App\Entity\TaskQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskQueue|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskQueue|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskQueue[]    findAll()
 * @method TaskQueue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskQueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskQueue::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TaskQueue $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(TaskQueue $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllTaskQueuesWithTasks(): array
    {
        return $this->createQueryBuilder('q')
            ->select('q', 't')
            ->join('q.tasks', 't')
            ->groupBy('q')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return TaskQueue[] Returns an array of TaskQueue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskQueue
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
