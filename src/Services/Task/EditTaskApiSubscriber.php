<?php


namespace App\Services\Task;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Services\Log\LogAdder;
use App\Services\User\UserProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class EditTaskApiSubscriber implements EventSubscriberInterface
{
    public function __construct
    (
        private LogAdder     $logAdder,
        private UserProvider $userProvider
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['addLog', EventPriorities::POST_WRITE],
        ];
    }

    public function addLog(ViewEvent $event): void
    {
        if (explode("/", $event->getRequest()->getPathInfo())[2] != "tasks" && $event->getRequest()->getMethod() != "PATCH") {
            return;
        }

        $task = $event->getControllerResult();
        $user = $this->userProvider->getUserByEmail($event->getRequest()->getSession()->get('_security.last_username'));
        $oldQueue = $event->getRequest()->attributes->get('previous_data')->getQueue();

        $this->logAdder->addQueueUpdateLog($task, $user, $oldQueue);
    }
}