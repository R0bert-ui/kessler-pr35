<?php
class User {
    private $conn;
    private $table = 'users';
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $sql = 'INSERT INTO ' . $this->table
            . ' (name, email, password) VALUES (:name, :email, :password)';
        $stmt = $this->conn->prepare($sql);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    public function getAll() {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();
        return $stmt;
    }
    public function delete($id) {
        $stmt = $this->conn->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}