<?php
namespace App\Repositories;

class Repository
{
    public $dbh;
    public function __construct()
    {
        try {
            $this->dbh = new \PDO('mysql:host=localhost;dbname=suai', 'root', '29111999C');
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }
}