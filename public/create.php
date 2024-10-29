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

require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Bill</title>
    <link rel="stylesheet" href="../style.css"> <!-- Ensure this is linked to your CSS -->
</head>
<body>
    <main class="create-bill-page">
        <h2>Create a New Bill</h2>
        <?php if ($message): ?>
            <p class="success-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Title: <input type="text" name="title" required></label><br>
            <label>Description: <textarea name="description" required></textarea></label><br>
            <button type="submit">Create Bill</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </main>
    
    <?php require_once '../views/footer.php'; ?>
</body>
</html>
