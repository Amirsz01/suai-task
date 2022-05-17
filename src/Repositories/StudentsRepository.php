<?php

namespace App\Repositories;

use App\Repositories\Repository;

class StudentsRepository extends Repository {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Getting all records.
     * 
     * @return Student[]
     */
    public function getAll() {
        return $this->dbh->query("SELECT * FROM `Students`")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Students` WHERE `id`=?");
            $query->execute([$id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getByClassesId($id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Students` INNER JOIN `Students_Groups` ON `Students`.`id`=`Students_Groups`.`student_id` LEFT JOIN `Classes_For_Groups` ON `Students_Groups`.`group_id`=`Classes_For_Groups`.`group_id` WHERE `Classes_For_Groups`.`classes_id`=?");
            $query->execute([$id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByTaskId($id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Students` LEFT JOIN `Students_Groups` ON `Students`.`id`=`Students_Groups`.`student_id` LEFT JOIN `Tasks_For_Groups` ON `Students_Groups`.`group_id`=`Tasks_For_Groups`.`group_id` WHERE `Tasks_For_Groups`.`task_id`=?");
            $query->execute([$id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCountByTaskId($id) {
        $tasks = $this->getByTaskId($id);
        return count($tasks);
    }
}
