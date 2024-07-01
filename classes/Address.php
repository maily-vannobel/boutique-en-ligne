<?php
class Address {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function addAddress($userId, $deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress) {
        $query = "INSERT INTO addresses (delivery_address, address_complement, postal_code, city, billing_address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress]);
        $addressId = $this->db->lastInsertId();
        $this->linkAddressToUser($userId, $addressId);
        return true;
    }

    public function updateAddress($addressId, $deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress) {
        $query = "UPDATE addresses SET delivery_address = ?, address_complement = ?, postal_code = ?, city = ?, billing_address = ? WHERE address_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress, $addressId]);
    }

    public function getAddressesByUserId($userId) {
        $query = "SELECT a.* FROM addresses a JOIN user_addresses ua ON a.address_id = ua.address_id WHERE ua.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function linkAddressToUser($userId, $addressId) {
        $query = "INSERT INTO user_addresses (user_id, address_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId, $addressId]);
    }
    public function addBillingAddress($user_id, $billing_address, $postal_code, $city) {
        $query = "INSERT INTO addresses (billing_address, postal_code, city) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$billing_address, $postal_code, $city]);
        $addressId = $this->db->lastInsertId();
        $this->linkAddressToUser($user_id, $addressId);
        return true;
    }}
?>
