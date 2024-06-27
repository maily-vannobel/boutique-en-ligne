<?php

require_once __DIR__ . '/Database.php';

class ProductSubcategories extends Database {

    public function __construct() {
        parent::__construct();
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

    public function getSubcategoriesByProductId($product_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT subcategories.* FROM subcategories JOIN product_subcategories ON subcategories.subcategories_id = product_subcategories.subcategories_id WHERE product_subcategories.product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function removeProductFromAllSubcategories($product_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM product_subcategories WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
}
?>