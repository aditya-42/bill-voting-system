<?php
require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $authController->register($_POST['username'], $_POST['password'], $_POST['role']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Role: 
            <select name="role">
                <option value="Member of Parliament">Member of Parliament</option>
                <option value="Reviewer">Reviewer</option>
                <option value="Administrator">Administrator</option>
            </select>
        </label><br>
        <button type="submit">Register</button>
    </form>
    <p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>
