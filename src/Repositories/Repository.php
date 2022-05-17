<?php
namespace App\Repositories;

class Repository
{
    protected $dbh;
    public function __construct()
    {
        try {
            $this->dbh = new \PDO('mysql:host=localhost;dbname=suai', 'root', '29111999C');
            $this->dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }
}