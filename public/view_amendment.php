<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Member of Parliament');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);

require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suggest an Amendment</title>
    <link rel="stylesheet" href="../style.css"> 
</head>
<body>
    <main class="view-amendments-page">
    <h3>Amendments suggested by Reviewers</h3>
    <?php if (!empty($bill['amendments'])): ?>
        <ul>
            <?php foreach ($bill['amendments'] as $amendment): ?>
                <li>
                    <strong><?php echo htmlspecialchars($amendment['author']['username']); ?></strong> on <?php echo htmlspecialchars($amendment['timestamp']); ?>: 
                    <?php echo htmlspecialchars($amendment['comment']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No amendments suggested yet.</p>
    <?php endif; ?>
    <a class="back-link" href="list.php">Back to Bills</a>

    </main>
</body>
</html>



<?php
require_once '../views/footer.php'; 
?>
