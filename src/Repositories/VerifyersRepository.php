<?php

namespace App\Repositories;

use App\Repositories\Repository;

class VerifyersRepository extends Repository {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Getting all records.
     * 
     * @return Verifier[]
     */
    public function getAll() {
        return $this->dbh->query("SELECT * FROM `Verifyers`")->fetchAll();
    }

    /**
     * Getting all records with inner join tasks.
     * 
     * @return Verifier[]
     */
    public function getAllWithTasks() {
        return $this->dbh->query("SELECT * FROM `Verifyers` INNER JOIN `Verifyers_For_Tasks` ON `Verifyers`.`id`=`Verifyers_For_Tasks`.`verifyers_id`")->fetchAll();
    }

    /**
     * Getting all records by task id.
     * 
     * @param id Task ID
     * 
     * @return Verifier[]
     */
    public function getByTaskId($id) {
        $query = $this->dbh->prepare("SELECT * FROM `Verifyers` LEFT JOIN `Verifyers_For_Tasks` ON `Verifyers`.`id`=`Verifyers_For_Tasks`.`verifyers_id` WHERE `Verifyers_For_Tasks`.`task_id`=?");
        $query->execute([$id]);
        return $query->fetchAll();
    }

    /**
     * Getting workloads for all verifyers. Calculation in mysql query.
     * 
     * @param id Task ID
     * 
     * @return Verifier[]
     */
    public function getAllWorkLoad() {
        $query = $this->dbh->query("SELECT `Verifyers`.`id`, `Verifyers`.`name` , COUNT(`id`) as COUNT FROM `Verifyers` INNER JOIN `Verifyers_For_Tasks` ON `Verifyers`.`id`=`Verifyers_For_Tasks`.`verifyers_id` GROUP BY `Verifyers`.`id`");
        return $query->fetchAll();
    }
}