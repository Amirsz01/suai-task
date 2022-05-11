<?php

namespace App\Repositories;

use App\Repositories\Repository;

class VerifyersRepository extends Repository {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        return $this->dbh->query("SELECT * FROM `Verifyers`")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByTaskId($id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Verifyers` LEFT JOIN `Verifyers_For_Tasks` ON `Verifyers`.`id`=`Verifyers_For_Tasks`.`verifyers_id` WHERE `Verifyers_For_Tasks`.`task_id`=?");
            $query->execute([$id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllWorkLoad() {
        try {
            $query = $this->dbh->query("SELECT `Verifyers`.`id`, `Verifyers`.`name` , COUNT(`id`) as COUNT FROM `Verifyers` INNER JOIN `Verifyers_For_Tasks` ON `Verifyers`.`id`=`Verifyers_For_Tasks`.`verifyers_id` GROUP BY `Verifyers`.`id`");
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}