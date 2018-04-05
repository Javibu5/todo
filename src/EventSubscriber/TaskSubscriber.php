<?php

namespace App\EventSubscriber;

use App\Event\TaskEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function onTaskCreated(TaskEvent $event)
    {
        $task = $event->getTask();
        $this->logger->info("[TASK CREATED] {$task->getDescription()} by {$task->getOwner()}");
    }

    public static function getSubscribedEvents()
    {
        return [
           'task.created' => 'onTaskCreated',
        ];
    }
}
