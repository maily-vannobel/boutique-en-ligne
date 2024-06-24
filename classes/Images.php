<?php
require_once './Database.php';

class Images extends Database {

    private $image_id;
    private $url;
    private $product_id;

    public function __construct() {
        parent::__construct();
    }

    public function addImageToProduct($product_id, $url) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO images (url) VALUES (:url)");
            $stmt->bindParam(':url', $url);
            $stmt->execute();
            $image_id = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_id) VALUES (:product_id, :image_id)");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':image_id', $image_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function removeImageFromProduct($product_id, $image_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = :product_id AND image_id = :image_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':image_id', $image_id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM images WHERE image_id = :image_id");
            $stmt->bindParam(':image_id', $image_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getImagesByProductId($product_id) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT images.* FROM images JOIN product_images ON images.image_id = product_images.image_id WHERE product_images.product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>