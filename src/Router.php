<?php

namespace App;

use App\Controllers\MainController;

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

Router::route('tasks', function($id = 1) {
    $mainConroller = new MainController();
    return $mainConroller->tasksByStudent($id);
});

Router::route('students', function($id = 1) {
    $mainConroller = new MainController();
    return $mainConroller->studentsCountByTask($id);
});

Router::route('task/info', function($id = 1) {
    $mainConroller = new MainController();
    return $mainConroller->taskInfo($id);
});

Router::route('workloads', function() {
    $mainConroller = new MainController();
    return $mainConroller->workload();
});

Router::route('task/critical', function() {
    $mainConroller = new MainController();
    return $mainConroller->criticalTasks();
});

Router::route('classes', function($id = 1) {
    $mainConroller = new MainController();
    return $mainConroller->studentsByClasses($id);
});

Router::route('task/info/get', function() {
    $mainConroller = new MainController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getTaskInfo($POST->id));
});

Router::route('tasks/get', function() {
    $mainConroller = new MainController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getTasksByStudent($POST->id));
});

Router::route('classes/get', function() {
    $mainConroller = new MainController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getStudentsByClasses($POST->id));
});

Router::route('students/get', function($id = 1) {
    $mainConroller = new MainController();
    $POST = \json_decode(file_get_contents('php://input'));
    return \json_encode($mainConroller->getStudentsCountByTask($POST->id));
});