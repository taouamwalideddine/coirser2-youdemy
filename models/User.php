<?php
require_once 'CrudInterface.php';
require_once 'UserInterface.php';

abstract class User implements CrudInterface, UserInterface {
    protected $db;
    protected $id;
    protected $username;
    protected $email;
    protected $role;


    public function __construct($db, $userData = null) {
        $this->db = $db;
        if ($userData) {
            $this->id = $userData['id'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
        }
    }
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->bindParam(':role', $this->role);
        return $stmt->execute();
    }

    public function read($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAll() {
        $sql = "SELECT * FROM users WHERE role <> :role";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $this->role);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserbyId($id) {
        $sql = "SELECT * FROM users where id_user = :id_user";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $this->role);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRole() {
        return $this->role;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }


    abstract public function getSpecificData();
}

