<?php
require_once __DIR__ . '/Database.php';

class Users extends Database {
    private $user_id;
    private $last_name;
    private $first_name;
    private $email;
    private $password;
    private $phone;
    private $role_id;

    public function __construct() {
        parent::__construct();
    }

    public function create_user($last_name, $first_name, $email, $password, $phone, $role_id = 2) {
        if (!$this->validate_email($email)) {
            throw new Exception('Invalid email format');
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = 'INSERT INTO users (last_name, first_name, email, password, phone, role_id) 
                VALUES (:last_name, :first_name, :email, :password, :phone, :role_id)';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role_id', $role_id);
        
        if ($stmt->execute()) {
            return $this->getConnection()->lastInsertId();
        } else {
            throw new Exception('Failed to create user');
        }
    }

    public function get_user_by_id($user_id) {
        $sql = 'SELECT user_id, last_name, first_name, email, phone, role_id 
                FROM users WHERE user_id = :user_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_user_by_email($email) {
        $sql = 'SELECT user_id, last_name, first_name, email, password, phone, role_id 
                FROM users WHERE email = :email';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_user_by_phone($phone) {
        $sql = 'SELECT user_id, last_name, first_name, email, password, phone, role_id 
                FROM users WHERE phone = :phone';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_user($user_id) {
        $sql = 'DELETE FROM users WHERE user_id = :user_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    private function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getRoleId() {
        return $this->role_id;
    }
}
?>
