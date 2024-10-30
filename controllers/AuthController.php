<?php
require_once __DIR__ . '/../repositories/UserRepository.php';

class AuthController {
    private $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function register($username, $password, $role) {
        try {
            if (empty($username) || empty($password) || empty($role)) {
                throw new Exception("All fields are required.");
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $user = [
                'username' => $username,
                'password' => $hashedPassword,
                'role' => $role
            ];

            $this->userRepo->saveUser($user);
            error_log("User registered successfully: $username");
            return "Registration successful.";
        } catch (Exception $e) {
            error_log("Registration failed: " . $e->getMessage());
            return "Registration failed: " . $e->getMessage();
        }
    }

    public function login($username, $password) {
        try {
            $user = $this->userRepo->findUserByUsername($username);

            if (!$user) {
                error_log("Login failed: User not found - $username");
                return false;
            }

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = [
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                error_log("User logged in successfully: $username");
                return true;
            } else {
                error_log("Login failed: Incorrect password for user - $username");
                return false;
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        error_log("User logged out: " . ($_SESSION['user']['username'] ?? 'Unknown'));
        header("Location: index.php");
        exit();
    }
}
?>