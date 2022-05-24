<?php

namespace App\Repositories;

use App\Repositories\Repository;

class TasksRepository extends Repository {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Getting all records.
     * 
     * @return Task[]
     */
    public function getAll() {
        return $this->dbh->query("SELECT * FROM `Tasks`")->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Getting all records with inner join verifyers.
     * 
     * @return Verifier[]
     */
    public function getAllWithVerifyers() {
        return $this->dbh->query("SELECT * FROM `Tasks` INNER JOIN `Verifyers_For_Tasks` ON `Tasks`.`id`=`Verifyers_For_Tasks`.`task_id`")->fetchAll();
    }

    /**
     * Getting all records with inner join students.
     * 
     * @return Verifier[]
     */
    public function getAllWithStudents() {
        return $this->dbh->query("SELECT * FROM `Tasks` INNER JOIN `Tasks_For_Students` ON `Tasks`.`id`=`Tasks_For_Students`.`task_id`")->fetchAll();
    }

    /**
     * Getting all records by student id.
     * 
     * @return Verifier[]
     */
    public function getByStudentId($student_id) {
        $query = $this->dbh->prepare("SELECT * FROM `Tasks` INNER JOIN `Tasks_For_Students` ON `Tasks`.`id`=`Tasks_For_Students`.`task_id` WHERE `Tasks_For_Students`.`student_id`=?");
        $query->execute([$student_id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Getting statistic for critical tasks. Calculation in mysql query.
     * 
     * @return Verifier[]
     */
    public function getStatisticForVerifyers() {
        return $this->dbh->query("SELECT `Tasks`.`id`, `Tasks`.`title`,(COUNT(DISTINCT(`Tasks_For_Students`.`student_id`))/COUNT(DISTINCT(`Verifyers_For_Tasks`.`verifyers_id`))) AS 'RELATION' FROM `Tasks` INNER JOIN `Tasks_For_Students` ON `Tasks`.`id` = `Tasks_For_Students`.`task_id` JOIN `Verifyers_For_Tasks` ON `Tasks`.`id`=`Verifyers_For_Tasks`.`task_id` GROUP BY `Tasks`.`id`")->fetchAll(\PDO::FETCH_ASSOC);
    }
}