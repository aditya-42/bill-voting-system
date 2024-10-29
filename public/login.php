<?php
session_start();
require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($authController->login($_POST['username'], $_POST['password'])) {
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}


require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css"> 
</head>
<body>
    <main class="login-page">
        <h2>Login</h2>
        <form method="post">
            <label>Username: <input type="text" name="username" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <button type="submit">Login</button>
        </form>
        <p><?php echo htmlspecialchars($message); ?></p>
    </main>
</body>
</html>

<?php
require_once '../views/footer.php'; 
?>
