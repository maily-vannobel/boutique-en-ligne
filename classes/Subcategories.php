<?php
require_once './Database.php';

class Subcategories extends Database {

    private $subcategories_id;
    private $subcategories_name;
    private $category_id;

    public function __construct() {
        parent::__construct();
    }

    public function getAllSubcategories() {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM subcategories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //MÉTHODE 1 : recup sous-cat par ID
    public function getSubcategoryById($id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM subcategories WHERE subcategories_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //MÉTHODE 2 : ajouter une sous-cat
    public function addSubcategory($subcategories_name, $category_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO subcategories (subcategories_name, category_id) VALUES (:subcategories_name, :category_id)");
            $stmt->bindParam(':subcategories_name', $subcategories_name);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //MÉTHODE 3 : mise à jour sous-cat
    public function updateSubcategory($id, $subcategories_name, $category_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("UPDATE subcategories SET subcategories_name = :subcategories_name, category_id = :category_id WHERE subcategories_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':subcategories_name', $subcategories_name);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //MÉTHODE 4 : supprimer sous-cat
    public function deleteSubcategory($id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM subcategories WHERE subcategories_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addProductToSubcategory($product_id, $subcategories_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO product_subcategories (product_id, subcategories_id) VALUES (:product_id, :subcategories_id)");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':subcategories_id', $subcategories_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function removeProductFromSubcategory($product_id, $subcategories_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM product_subcategories WHERE product_id = :product_id AND subcategories_id = :subcategories_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':subcategories_id', $subcategories_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getProductsBySubcategoryId($subcategories_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT products.* FROM products JOIN product_subcategories ON products.product_id = product_subcategories.product_id WHERE product_subcategories.subcategories_id = :subcategories_id");
            $stmt->bindParam(':subcategories_id', $subcategories_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>