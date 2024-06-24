<?php 
require_once './Database.php';

class Products extends Database {

    private $product_id;
    private $product_name;
    private $description;
    private $stock;
    private $ingredients;
    private $quantity_weight;
    private $price;

    public function __construct() {
        parent::__construct();
    }

    public function getAllProducts() {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM products");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getProductById($id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addProduct($product_name, $description, $stock, $ingredients, $quantity_weight, $price) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO products (product_name, description, stock, ingredients, quantity_weight, price) VALUES (:product_name, :description, :stock, :ingredients, :quantity_weight, :price)");
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':ingredients', $ingredients);
            $stmt->bindParam(':quantity_weight', $quantity_weight);
            $stmt->bindParam(':price', $price);
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateProduct($id, $product_name, $description, $stock, $ingredients, $quantity_weight, $price) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("UPDATE products SET product_name = :product_name, description = :description, stock = :stock, ingredients = :ingredients, quantity_weight = :quantity_weight, price = :price WHERE product_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':ingredients', $ingredients);
            $stmt->bindParam(':quantity_weight', $quantity_weight);
            $stmt->bindParam(':price', $price);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteProduct($id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>