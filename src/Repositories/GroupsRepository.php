<?php

namespace App\Repositories;

use App\Repositories\Repository;

class GroupsRepository extends Repository {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Getting all records.
     * 
     * @return Group[]
     */
    public function getAll() {
        return $this->dbh->query("SELECT * FROM `Groups`")->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Getting all records by classes id.
     * 
     * @return Group[]
     */
    public function getByClassesId($id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Groups` LEFT JOIN `Classes_For_Groups` ON `Groups`.`id`=`Classes_For_Groups`.`group_id` WHERE `Classes_For_Groups`.`classes_id`=?");
            $query->execute([$id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Getting all records by task id.
     * 
     * @return Group[]
     */
    public function getByTaskId($id) {
        try {
            $query = $this->dbh->prepare("SELECT * FROM `Groups` LEFT JOIN `Tasks_For_Groups` ON `Groups`.`id`=`Tasks_For_Groups`.`group_id` WHERE `Tasks_For_Groups`.`task_id`=?");
            $query->execute([$id]);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}