<?php

namespace App\Controllers;

use App\Services\Sorter;
use App\Controllers\Controller;
use App\Repositories\TasksRepository;
use App\Repositories\StudentsRepository;


class StudentController extends Controller  {
    private $st;
    private $ts;
    private $sorter;

    public function __construct() {
        parent::__construct();
        $this->st = new StudentsRepository();
        $this->ts = new TasksRepository();
        $this->sorter = new Sorter();
    }

    /**
     * Display list of tasks for a student.
     * 
     * @param student_id Student ID
     * 
     * @return page
     */
    public function tasksByStudent($student_id) {
        $tasks = $this->ts->getByStudentId($student_id);
        try {
            $content = $this->twig->render('Student/tasksByStudent.twig', ['tasks' => $tasks]);
        } catch(\Exception $e) {
            return $e->getPrevious()->getMessage();
        }
        return $content;
    }

    /**
     * Getting a list of tasks for student.
     * 
     * @param student_id Student ID
     * 
     * @return Task[]
     */
    public function getTasksByStudent($student_id) {
        $tasks = $this->ts->getByStudentId($student_id);
        return [
            'tasks' => $tasks
        ];
    }
}