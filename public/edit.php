<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Member of Parliament');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_SESSION['user']['username'];

    $billController->editBill($billId, $title, $description, $author);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Bill</title>
</head>
<body>
    <h2>Edit Bill - <?php echo htmlspecialchars($bill['title'] ?? ''); ?></h2>
    <form method="post">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($bill['title'] ?? ''); ?>" required><br>
        <label>Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($bill['description'] ?? ''); ?></textarea><br>
        <button type="submit">Save Changes</button>
    </form>
    <h3>Previous Versions</h3>
    <?php if (!empty($bill['versions'])): ?>
        <ul>
            <?php foreach ($bill['versions'] as $version): ?>
                <li>
                    <strong><?php echo htmlspecialchars($version['title']); ?></strong> - 
                    <?php echo htmlspecialchars($version['description']); ?>
                    (Edited by <?php echo htmlspecialchars($version['author']); ?> on <?php echo htmlspecialchars($version['timestamp']); ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No previous versions available.</p>
    <?php endif; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
