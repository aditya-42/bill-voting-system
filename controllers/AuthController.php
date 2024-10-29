<?php
require_once __DIR__ . '/../repositories/UserRepository.php';

class AuthController {
    private $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function register($username, $password, $role) {
        if ($this->userRepo->findUserByUsername($username)) {
            return "Username already exists.";
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $user = [
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role
        ];

        $this->userRepo->saveUser($user);
        return "Registration successful.";
    }

    public function login($username, $password) {

        $user = $this->userRepo->findUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return true;
        }

        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>
