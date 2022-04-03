<?php


namespace App\Services\Log;


use App\Entity\Log;
use App\Entity\Task;
use App\Entity\TaskComment;
use App\Entity\TaskQueue;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class LogAdder
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function add(Task $task,User $user, ?TaskComment $comment, ?TaskQueue $oldQueue, ?string $value, bool $flush = true): Log
    {
        $log = new Log();
        $log->setTask($task);
        $log->setUser($user);
        $log->setComment($comment);
        $log->setOldQueue($oldQueue);
        $log->setValue($value);

        $this->entityManager->persist($log);
        if($flush){
            $this->entityManager->flush();
        }
        return $log;
    }

    public function addNewTaskLog(Task $task, User $user, bool $flush = true): Log
    {
        return $this->add($task, $user, null, null, "add", $flush);
    }

    public function addNewCommentLog(TaskComment $comment, bool $flush = true): Log
    {
        return $this->add($comment->getTask(), $comment->getUser(), $comment, null, "comment", $flush);
    }

    public function addNewCommentWithQueueUpdateLog(TaskComment $comment, TaskQueue $oldQueue, bool $flush = true): Log
    {
        return $this->add($comment->getTask(), $comment->getUser(), $comment, $oldQueue, "updateComment", $flush);
    }

    public function addQueueUpdateLog(Task $task, User $user, TaskQueue $oldQueue, bool $flush = true): Log
    {
        return $this->add($task, $user, null, $oldQueue, "queueUpdate", $flush);
    }

    public function addEditTaskLog(Task $task, User $user, TaskQueue $oldQueue, bool $flush = true): Log
    {
        return $this->add($task, $user, null, $oldQueue, "taskEdit", $flush);
    }
}