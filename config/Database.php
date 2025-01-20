<?php

class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        $host = "localhost";
        $dbname = "youdemy";
        $user = "root";  
        $pass = "";
        
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES 'utf8'");
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }