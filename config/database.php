<?php

class Database {

    public $conn = null;

    public function __construct($db,$host,$user,$password) {
        $this->conn = new MySqli($host,$user,$password,$db);
    }

    public function getConn() {
        return $this->conn;
    }
}
