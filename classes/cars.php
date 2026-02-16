<?php
class Car {
    private $conn;
    private $table = 'cars';
    public $id;
    public $brand;
    public $model;
    public $year;
    public $price;
    public $mileage;
    public $gearbox;
    public $fuel;
    public $popularity;
    public $photo_url;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $sql = 'INSERT INTO ' . $this->table
            . ' (brand, model, year, price, mileage, gearbox, fuel, popularity, photo_url)'
            . ' VALUES (:brand, :model, :year, :price, :mileage, :gearbox, :fuel, :popularity, :photo_url)';
        $stmt = $this->conn->prepare($sql);
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':mileage', $this->mileage);
        $stmt->bindParam(':gearbox', $this->gearbox);
        $stmt->bindParam(':fuel', $this->fuel);
        $stmt->bindParam(':popularity', $this->popularity);
        $stmt->bindParam(':photo_url', $this->photo_url);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    public function getAll() {
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    public function getById($id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id = $row['id'];
            $this->brand = $row['brand'];
            $this->model = $row['model'];
            $this->year = $row['year'];
            $this->price = $row['price'];
            $this->mileage = $row['mileage'];
            $this->gearbox = $row['gearbox'];
            $this->fuel = $row['fuel'];
            $this->popularity = $row['popularity'];
            $this->photo_url = $row['photo_url'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }
    public function update() {
        $sql = 'UPDATE ' . $this->table . ' SET
            brand = :brand,
            model = :model,
            year = :year,
            price = :price,
            mileage = :mileage,
            gearbox = :gearbox,
            fuel = :fuel,
            popularity = :popularity,
            photo_url = :photo_url
            WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':mileage', $this->mileage);
        $stmt->bindParam(':gearbox', $this->gearbox);
        $stmt->bindParam(':fuel', $this->fuel);
        $stmt->bindParam(':popularity', $this->popularity);
        $stmt->bindParam(':photo_url', $this->photo_url);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
    public function delete($id) {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
