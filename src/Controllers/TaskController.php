<?php

namespace App\Controllers;

use App\Services\Sorter;
use App\Services\Counter;
use App\Controllers\Controller;
use App\Repositories\TasksRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\VerifyersRepository;

class TaskController extends Controller {
    private $st;
    private $gr;
    private $ts;

    public function __construct() {
        parent::__construct();    
        $this->st = new StudentsRepository();
        $this->gr = new GroupsRepository();
        $this->ts = new TasksRepository();
        $this->vr = new VerifyersRepository();
    }

    /**
     * Display info (groups and students lists) of task.
     * 
     * @param id Task ID
     * 
     * @return page
     */
    public function taskInfo($id) {
        $students = $this->st->getByTaskId($id);
        $groups = $this->gr->getByTaskId($id);
        return $this->twig->render('Task/taskInfo.twig', ['students' => $students, 'groups' => $groups]);
    }

    /**
     * Getting task info (groups and students lists) of task.
     * 
     * @param id Task ID
     * 
     * @return Array<Student[],Group[]>
     */
    public function getTaskInfo($id) {
        $students = $this->st->getByTaskId($id);
        $groups = $this->gr->getByTaskId($id);
        return [
            'students' => $students, 
            'groups' => $groups
        ];
    }
    
    /**
     * Display critical tasks.
     * 
     * @return page
     */
    public function criticalTasks() {
        $tasksWithStudents = $this->ts->getAllWithStudents();
        $taskWithVerifyers = $this->ts->getAllWithVerifyers();
        $studentsCount = Counter::mapCounter($tasksWithStudents, 'task_id');
        $verifiersCount = Counter::mapCounter($taskWithVerifyers, 'task_id');
        $tasksStats = array_map(function($item_1, $item_2) {
            return [
                'relation' => $item_1['count']/$item_2['count'],
                ...$item_1,
                ...$item_2,
            ];
        }, $studentsCount, $verifiersCount);
        Sorter::usortEx($tasksStats, 'relation', 'DESC');
        return $this->twig->render('Task/criticalTasks.twig', ['tasksStats' => $tasksStats]);
    }

    /**
     * Display count students of task.
     * 
     * @param id Task ID
     * 
     * @return page
     */
    public function studentsCountByTask($id) {
        return $this->twig->render('Task/studentsByTask.twig', ['task_id' => $id, 'count' => count($this->st->getByTaskId($id))]);
    }

    /**
     * Getting count students of task.
     * 
     * @param id Task ID
     * 
     * @return count Count of students
     */
    public function getStudentsCountByTask($id) {
        return [
            'count' => count($this->st->getByTaskId($id))
        ];
    }
    
    /**
     * Getting a list of students for task.
     * 
     * @param task_id Task ID
     * 
     * @return Student[]
     */
    public function studentsByTask($task_id) {
        $students = $this->st->getByTaskId($task_id);
        return $students;
    }
}