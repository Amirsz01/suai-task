<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repositories\StudentsRepository;

class ClassesController extends Controller {
    private $st;

    public function __construct() {
        parent::__construct();
        $this->st = new StudentsRepository();
    }

    /**
     * Display list of students for individual classes.
     * 
     * @param id Classes ID
     * 
     * @return page
     */
    public function studentsByClasses($id) {
        $students = $this->st->getByClassesId($id);
        try {
            $content = $this->twig->render('Classes/studentsByClasses.twig', ['students' => $students]);
        } catch(\Exception $e) {
            return $e->getPrevious()->getMessage();
        }
        return $content;
    }

    /**
     * Getting a list of students for individual classes.
     * 
     * @param id Classes ID
     * 
     * @return Student[]
     */
    public function getStudentsByClasses($id) {
        $students = $this->st->getByClassesId($id);
        return [
            'students' => $students
        ];
    }
}