<?php
require_once __DIR__ . '../../config/db.php'; 

class UserRepository {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            error_log("Database connection failed: " . $this->conn->connect_error);
            die("Connection failed: " . $this->conn->connect_error);
        }
        error_log("Database connected successfully");
    }
   

    // Save a new user to the database
    public function saveUser($user) {
        // Check if the username already exists
        if ($this->findUserByUsername($user['username'])) {
            echo "User already exists!\n"; // Log message to terminal
            throw new Exception("User already exists!");
        }
    
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sss", $user['username'], $user['password'], $user['role']);
        
        // Execute the statement
        if (!$stmt->execute()) {
            echo "Failed to save user: " . $stmt->error . "\n"; // Log error message to terminal
            throw new Exception("Failed to save user: " . $stmt->error);
        }
    
        echo "User saved successfully: " . $user['username'] . "\n"; // Log success message to terminal
    }
    

    // Find a user by username
    public function findUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc(); // Fetch as an associative array
    }

    // Retrieve all users
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all as an associative array
    }

    // Update an existing user's information
    public function updateUser($user) {
        $sql = "UPDATE users SET password = ?, role = ? WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sss", $user['password'], $user['role'], $user['username']);
        
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user: " . $stmt->error);
        }
    }

    // Delete a user by username
    public function deleteUser($username) {
        $sql = "DELETE FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user: " . $stmt->error);
        }
    }
}
?>
