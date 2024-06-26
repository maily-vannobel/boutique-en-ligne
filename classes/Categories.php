<?php
require_once __DIR__ . '/Database.php';

class Categories extends Database {
    private $category_id;
    private $category_name;

    public function __construct() {
        parent::__construct();
    }

    public function getAllCategories() {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getCategoryById($id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addCategory($category_name) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
            $stmt->bindParam(':category_name', $category_name);
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateCategory($id, $category_name) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("UPDATE categories SET category_name = :category_name WHERE category_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':category_name', $category_name);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteCategory($id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getSubcategoriesByCategoryId($category_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM subcategories WHERE category_id = :category_id");
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>