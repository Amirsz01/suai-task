<?php

namespace App;

use App\Controllers\MainController;
use App\Controllers\TaskController;
use App\Controllers\ClassesController;
use App\Controllers\StudentController;
use App\Controllers\VerifierController;
use App\Services\Validator;

class Router {
    private static $routes = [];

    public static function route($action, $callback) {
        $action = trim($action, '/');
        self::$routes[$action] = $callback;
    }

    public static function dispatch($action) {
        $action = trim($action, '/');
        if(!array_key_exists($action, self::$routes))
        {
            throw new \Exception('Route not found');
        }
        $callback = self::$routes[$action];
        echo call_user_func($callback);
    }

    public static function getParams($params = []) {
        $POST = \json_decode(file_get_contents('php://input'));
        $result = array_map(function ($item) use ($POST){
            return Validator::checkInt($POST->$item) ? $POST->$item : throw new \Exception('Param validation error');
        }, $params);
        return $result;
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
    $classesController = new ClassesController();
    return $classesController->studentsByClasses($id);
});

Router::route('task/info/get', function() {
    $taskController = new TaskController();
    $params = Router::getParams(['id' => 'id']);
    return \json_encode($taskController->getTaskInfo($params['id']));
});

Router::route('student/tasks/get', function() {
    $studentController = new StudentController();
    $params = Router::getParams(['id' => 'id']);
    return \json_encode($studentController->getTasksByStudent($params['id']));
});

Router::route('classes/students/get', function() {
    $classesController = new ClassesController();
    $params = Router::getParams(['id' => 'id']);
    return \json_encode($classesController->getStudentsByClasses($params['id']));
});

Router::route('task/students/count/get', function() {
    $taskController = new TaskController();
    $params = Router::getParams(['id' => 'id']);
    $data = $taskController->getStudentsCountByTask($params['id']);
    return \json_encode($data);
});