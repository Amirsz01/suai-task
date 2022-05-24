<?php

namespace App\Controllers;

use App\Controllers\Controller;

class MainController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Action for request to main page.
     * 
     * @return page
     */
    public function index() {
        return $this->twig->render('Main/index.twig');
    }
}