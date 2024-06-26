<?php

require_once __DIR__ . '/Database.php';

class ProductFilters extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function addFilterToProduct($product_id, $filter_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO product_filter (product_id, filter_id) VALUES (:product_id, :filter_id)");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':filter_id', $filter_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function removeFilterFromProduct($product_id, $filter_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM product_filter WHERE product_id = :product_id AND filter_id = :filter_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':filter_id', $filter_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getFiltersByProductId($product_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT filters.* FROM filters JOIN product_filter ON filters.filter_id = product_filter.filter_id WHERE product_filter.product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function removeAllFiltersFromProduct($product_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM product_filter WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}
?>
