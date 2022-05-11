<?php

namespace App\Controllers;

use App\Repositories\StudentsRepository;
use App\Repositories\TasksRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\VerifyersRepository;
use App\Services\Sorter;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class MainController {
    private $twig;
    private $st;
    private $ts;
    private $gr;
    private $vr;
    private $sorter;

    public function __construct() {
        $this->st = new StudentsRepository();
        $this->ts = new TasksRepository();
        $this->gr = new GroupsRepository();
        $this->vr = new VerifyersRepository();
        $this->sorter = new Sorter();
        $loader = new FilesystemLoader('src/Templates');
        $this->twig = new Environment($loader);;
    }

    /**
     * Main page
     */
    public function index() {
        $students = $this->st->getAll();
        return $this->twig->render('Main/index.twig');
    }

    public function studentsByTask($task_id) {
        $students = $this->st->getByTaskId($task_id);
        return $students;
    }

    public function tasksByStudent($student_id) {
        $tasks = $this->ts->getByStudentId($student_id);
        return $this->twig->render('Main/tasksByStudent.twig', ['tasks' => $tasks]);
    }

    /**
     * Расчёт статистики "критически нагруженных" заданий: сколько студентов 
     * выполняет задание "делимое на" количество проверяющих это задание. Представить в
     * убывающем порядке.
     */
    public function criticalTasks() {
        $tasksStats = $this->ts->getStatisticForVerifyers();
        $this->sorter->usortEx($tasksStats, 'RELATION', 'DESC');
        return $this->twig->render('Main/criticalTasks.twig', ['tasksStats' => $tasksStats]);
    }

    /**
     * Расчёт нагрузки проверяющих: какое количество заданий необходимо проверить, в том числе совместные. Представить в убывающем порядке.
     */
    public function workload() {
        $workloads = $this->vr->getAllWorkload();
        $this->sorter->usortEx($workloads, 'COUNT', 'DESC');
        return $this->twig->render('Main/workload.twig', ['workloads' => $workloads]);
    }

    /**
     * Выборка для проверяющего количества студентов для 1го задания с учётом привязки групп со студентами;
     */
    public function studentsCountByTask($id) {
        return $this->twig->render('Main/studentsByTask.twig', ['task_id' => $id, 'count' => count($this->st->getByTaskId($id))]);
    }

    /**
     * Вывод списка студентов для конкретного занятия.
     */
    public function studentsByClasses($id) {
        $students = $this->st->getByClassesId($id);
        return $this->twig->render('Main/studentsByClasses.twig', ['students' => $students]);
    }

    /**
     * Выборка для задания списка групп и студентов;
     */
    public function taskInfo($id) {
        $students = $this->st->getByTaskId($id);
        $groups = $this->gr->getByTaskId($id);
        return $this->twig->render('Main/taskInfo.twig', ['students' => $students, 'groups' => $groups]);
    }


    public function getTaskInfo($id) {
        $students = $this->st->getByTaskId($id);
        $groups = $this->gr->getByTaskId($id);
        return [
            'students' => $students, 
            'groups' => $groups
        ];
    }

    public function getTasksByStudent($student_id) {
        $tasks = $this->ts->getByStudentId($student_id);
        return [
            'tasks' => $tasks
        ];
    }

    public function getStudentsByClasses($id) {
        $students = $this->st->getByClassesId($id);
        return [
            'students' => $students
        ];
    }

    public function getStudentsCountByTask($id) {
        return [
            'count' => count($this->st->getByTaskId($id))
        ];
    }
}