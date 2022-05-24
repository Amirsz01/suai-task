<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller implements \App\Interfaces\ControllerInterface {
    protected $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__.'/../Templates');
        $this->twig = new Environment($loader);
    }
}