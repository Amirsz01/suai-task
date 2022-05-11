<?php

namespace App\Repositories;

use App\Repositories\Repository;

class TasksRepository extends Repository {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        return $this->dbh->query("SELECT * FROM `Tasks`")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByStudentId($student_id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Tasks` INNER JOIN `Tasks_For_Students` ON `Tasks`.`id`=`Tasks_For_Students`.`task_id` WHERE `Tasks_For_Students`.`student_id`=?");
            $query->execute([$student_id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getStatisticForVerifyers() {
        return $this->dbh->query("SELECT `Tasks`.`id`, `Tasks`.`title`,(COUNT(DISTINCT(`Tasks_For_Students`.`student_id`))/COUNT(DISTINCT(`Verifyers_For_Tasks`.`verifyers_id`))) AS 'RELATION' FROM `Tasks` INNER JOIN `Tasks_For_Students` ON `Tasks`.`id` = `Tasks_For_Students`.`task_id` JOIN `Verifyers_For_Tasks` ON `Tasks`.`id`=`Verifyers_For_Tasks`.`task_id` GROUP BY `Tasks`.`id`")->fetchAll(\PDO::FETCH_ASSOC);
    }
}