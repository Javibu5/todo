<?php

namespace App\Controller;

use App\Entity\Task;
use App\Event\TaskEvent;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Services\Message;
use function PHPSTORM_META\type;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller
{
    /**
     * @Route("/", name="task")
     * @Route("/", name="homepage")
     */
    public function index(TaskRepository $repository)
    {
        $user =$this->getUser();
        $tasks = $repository->findBy([
            'owner' => $user,
        ]);


        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/task/new" , name = "task_new")
     *
     */
    public function new(Request $request , EventDispatcherInterface $dispatcher)
    {


        $user = $this->getUser();
        $task = new Task();
        $task->setOwner($user);
        $form = $this->createForm(TaskType::class , $task) ;
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $om = $this->getDoctrine()->getManager();
            $om->persist($task);
            $om->flush();

            $this->addFlash('positive' , "taskita creadita");
            $dispatcher->dispatch("task.created" , new TaskEvent($task));
            return $this->redirectToRoute('homepage');

        }

        return $this->render( 'task/new.html.twig' , [
        'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/task/{id}/edit" , name = "task_edit")
     */
    public function edit(Request $request , Task $task)
    {
        $this->denyAccessUnlessGranted('EDIT' ,$task);

        $form = $this->createForm(TaskType::class , $task) ;
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $om = $this->getDoctrine()->getManager();
            $om->persist($task);
            $om->flush();

            $this->addFlash('positive' , "taskita editada");

            return $this->redirectToRoute('homepage');

        }

        return $this->render( 'task/new.html.twig' , [
            'form' => $form->createView(),
        ]);
    }
}
