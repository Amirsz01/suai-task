<?php

namespace App\Controllers;

use App\Services\Sorter;
use App\Services\Counter;
use App\Controllers\Controller;
use App\Repositories\VerifyersRepository;

class VerifierController extends Controller {
    private $st;
    private $gr;
    private $sorter;

    public function __construct() {
        parent::__construct();    
        $this->vr = new VerifyersRepository();
    }

    /**
     * Display workload of verifiers.
     * Default sorted type is DESC.
     * 
     * @return page
     */
    public function workload() {
        $verifiers = $this->vr->getAllWithTasks();
        $workloads = Counter::mapCounter($verifiers, 'id');
        Sorter::usortEx($workloads, 'count', 'DESC');
        return $this->twig->render('Verifier/workload.twig', ['workloads' => $workloads]);
    }
}