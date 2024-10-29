<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Member of Parliament');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billController->createBill($_POST['title'], $_POST['description'], $_SESSION['user']['username']);
    $message = 'Bill created successfully.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Bill</title>
</head>
<body>
    <h2>Create a New Bill</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <button type="submit">Create Bill</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>