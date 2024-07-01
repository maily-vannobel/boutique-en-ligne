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
    private $reset_token;
    private $reset_token_expires_at;

    public function __construct() {
        parent::__construct();
    }

    public function create_user($last_name, $first_name, $email, $password, $phone, $role_id = 2) {
        if (!$this->validate_email($email)) {
            throw new Exception('Invalid email format');
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        error_log("Hashed password at creation: " . $hashedPassword);
        
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
        $sql = 'SELECT user_id, last_name, first_name, email, password, phone, role_id 
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
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("User data retrieved by email: " . print_r($user, true));
        return $user;
    }
    
    public function get_user_by_phone($phone) {
        $sql = 'SELECT user_id, last_name, first_name, email, password, phone, role_id 
                FROM users WHERE phone = :phone';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("User data retrieved by phone: " . print_r($user, true));
        return $user;
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

    public function update_user($user_id, $last_name, $first_name, $email, $phone, $password = null) {
        $sql = 'UPDATE users SET last_name = :last_name, first_name = :first_name, email = :email, phone = :phone';
        if ($password) {
            $sql .= ', password = :password';
        }
        $sql .= ' WHERE user_id = :user_id';
    
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);
        }
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    public function update_user_password($user_id, $new_password) {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        error_log("Hashed password at update: " . $hashedPassword);
    
        $sql = 'UPDATE users SET password = :password WHERE user_id = :user_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':user_id', $user_id);
        $result = $stmt->execute();
        
        if ($result) {
            error_log("Password updated successfully for user_id: " . $user_id);
        } else {
            error_log("Failed to update password for user_id: " . $user_id);
        }
    
        return $result;
    }
                    
    public function store_password_reset_token($user_id, $token, $expires_at) {
        $sql = 'UPDATE users SET reset_token = :token, reset_token_expires_at = :expires_at WHERE user_id = :user_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires_at', $expires_at);
        $stmt->execute();
    }

}
?>
