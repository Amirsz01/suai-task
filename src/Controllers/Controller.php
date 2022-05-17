<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

interface ControllerInterface {
    public function __construct();
}

class Controller implements ControllerInterface {
    protected $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__.'/../Templates');
        $this->twig = new Environment($loader);
    }
}