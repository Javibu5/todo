<?php
/**
 * Created by PhpStorm.
 * User: i62capuj
 * Date: 5/04/18
 * Time: 15:20
 */

namespace App\Event;


use App\Entity\Task;
use Symfony\Component\EventDispatcher\Event;

class TaskEvent extends Event
{
    /**
     * @var Task
     */

    private $task;

    public function __construct(Task $task)
     {
         $this->task = $task;
     }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }


}