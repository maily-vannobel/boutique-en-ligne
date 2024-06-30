<?php 

require_once __DIR__ . '/Database.php';

class Products extends Database {
    private $product_id;
    private $product_name;
    private $description;
    private $quantity_weight;
    private $price;
    private $subcategories_id;

    public function __construct() {
        parent::__construct();
    }
        // Méthode publique pour obtenir la connexion
        public function getDatabaseConnection() {
            return $this->getConnection();
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

    public function addProduct($product_name, $description, $quantity_weight, $price, $category_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO products (product_name, description, quantity_weight, price, category_id) VALUES (:product_name, :description, :quantity_weight, :price, :category_id)");
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':quantity_weight', $quantity_weight);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateProduct($id, $product_name, $description, $quantity_weight, $price, $category_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("
                UPDATE products 
                SET product_name = :product_name, 
                    description = :description, 
                    quantity_weight = :quantity_weight, 
                    price = :price, 
                    category_id = :category_id 
                WHERE product_id = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':quantity_weight', $quantity_weight);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
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

    public function searchProducts($term) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_name LIKE :term");
            $term = "%$term%";
            $stmt->bindParam(':term', $term, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
    public function getProductsByFilters($filter_ids, $exclude_product_id = null) {
        $placeholders = implode(',', array_fill(0, count($filter_ids), '?'));
        $query = "SELECT DISTINCT p.* FROM products p
                  JOIN product_filter pf ON p.product_id = pf.product_id
                  WHERE pf.filter_id IN ($placeholders)";
        
        if ($exclude_product_id) {
            $query .= " AND p.product_id != ?";
            $filter_ids[] = $exclude_product_id;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($filter_ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getSimilarProducts($product_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT * FROM products WHERE subcategories_id = (SELECT subcategories_id FROM products WHERE product_id = :product_id) AND product_id != :product_id LIMIT 4");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>