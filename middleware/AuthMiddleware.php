<?php
session_start();

class AuthMiddleware {
    public static function requireAuth() {
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
            exit();
        }
    }

    public static function requireRole($requiredRole) {
        self::requireAuth();
        if ($_SESSION['user']['role'] !== $requiredRole) {
            header("Location: unauthorized.php");
            exit();
        }
    }

    public static function requireAnyRole(array $roles) {
        self::requireAuth();
        if (!in_array($_SESSION['user']['role'], $roles)) {
            header("Location: unauthorized.php");
            exit();
        }
    }
}
?>
