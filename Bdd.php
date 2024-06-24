<?php
class Bdd {
    public $conn;

    public function __construct() {
        try {
            // Connexion à la base de données
            $this->conn = new PDO('mysql:host=localhost:3306;dbname=maily-vannobel_pup_shop;charset=utf8', 'maily-pup-shop', '*37c13pzB');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>
