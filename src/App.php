<?php
namespace App;

class App {
    private $router;
    public function __construct() {
        $this->router = new Router();
    }

    public function render($action) {
        return $this->router->dispatch($action);
    }
}