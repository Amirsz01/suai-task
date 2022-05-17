<?php

namespace App;

use App\Controllers\MainController;
use App\Controllers\TaskController;
use App\Controllers\ClassesController;
use App\Controllers\StudentController;
use App\Controllers\VerifierController;

class Router {
    private static $routes = [];

    public static function route($action, $callback) {
        $action = trim($action, '/');
        self::$routes[$action] = $callback;
    }

    public static function dispatch($action) {
        $action = trim($action, '/');
        $callback = self::$routes[$action];
        echo call_user_func($callback);
    }
}

Router::route('/', function() {
    $mainConroller = new MainController();
    return $mainConroller->index();
});

Router::route('index', function() {
    $mainConroller = new MainController();
    return $mainConroller->index();
});

Router::route('student/tasks', function($id = 1) {
    $taskConroller = new StudentController();
    return $taskConroller->tasksByStudent($id);
});

Router::route('task/students/count', function($id = 1) {
    $taskController = new TaskController();
    return $taskController->studentsCountByTask($id);
});

Router::route('task/info', function($id = 1) {
    $taskController = new TaskController();
    return $taskController->taskInfo($id);
});

Router::route('verifier/workloads', function() {
    $verifierController = new VerifierController();
    return $verifierController->workload();
});

Router::route('task/critical', function() {
    $taskController = new TaskController();
    return $taskController->criticalTasks();
});

Router::route('classes/students', function($id = 1) {
    $studentController = new ClassesController();
    return $studentController->studentsByClasses($id);
});

Router::route('task/info/get', function() {
    $mainConroller = new TaskController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getTaskInfo($POST->id));
});

Router::route('student/tasks/get', function() {
    $mainConroller = new StudentController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getTasksByStudent($POST->id));
});

Router::route('classes/students/get', function() {
    $mainConroller = new ClassesController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getStudentsByClasses($POST->id));
});

Router::route('task/students/count/get', function() {
    $mainConroller = new TaskController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getStudentsCountByTask($POST->id));
});