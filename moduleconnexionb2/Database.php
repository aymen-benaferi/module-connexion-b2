<?php

class Database {
    private static $instance;
    private $pdo;

    private function __construct() {
        $host = "hostname";
        $dbname = "dbname";
        $username = "username";
        $password = "password";

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}

?>