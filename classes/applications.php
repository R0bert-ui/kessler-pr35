<?php
class Application {
    private $conn;
    private $table = 'applications';
    public $id;
    public $car_id;
    public $user_id;
    public $full_name;
    public $phone;
    public $email;
    public $comment;
    public $status;
    public $created_at;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $sql = 'INSERT INTO ' . $this->table
            . ' (car_id, user_id, full_name, phone, email, comment, status) '
            . 'VALUES (:car_id, :user_id, :full_name, :phone, :email, :comment, :status)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':car_id', $this->car_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':comment', $this->comment);
        $stmt->bindParam(':status', $this->status);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    public function getAll() {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt;
    }
    public function delete($id) {
        $stmt = $this->conn->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
