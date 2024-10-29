<?php
session_start();
require_once '../repositories/UserRepository.php';

class UserController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function register($username, $password, $role) {
        $existingUser = $this->userRepository->findUserByUsername($username);
        if ($existingUser) {
            echo "User already exists!";
            return;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = ['username' => $username, 'password' => $hashedPassword, 'role' => $role];
        $this->userRepository->saveUser($user);
        echo "Registration successful!";
    }

    public function login($username, $password, $rememberMe = false) {
        $user = $this->userRepository->findUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = ['username' => $username, 'role' => $user['role']];
            
            if ($rememberMe) {
                setcookie('rememberMe', $username, time() + (86400 * 30), "/"); // Expires in 30 days
            }
            header("Location: dashboard.php");
        } else {
            echo "Invalid login credentials!";
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie('rememberMe', '', time() - 3600, "/");
        header("Location: login.php");
    }
}
?>
