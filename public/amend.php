<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Reviewer');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amendment = [
        'comment' => $_POST['comment'],
        'author' => $_SESSION['user'],
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    $billController->addAmendment($billId, $amendment);
    header("Location: view_bill.php?id=$billId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suggest an Amendment</title>
</head>
<body>
    <h2>Suggest an Amendment for: <?php echo htmlspecialchars($bill['title']); ?></h2>
    <form method="post">
        <label>Comment:</label><br>
        <textarea name="comment" required></textarea><br>
        <button type="submit">Submit Amendment</button>
    </form>
    <h3>Previous Amendments</h3>
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
    <a href="view_bill.php?id=<?php echo $billId; ?>">Back to Bill</a>
</body>
</html>
