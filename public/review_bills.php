<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Administrator');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();
$billsUnderReview = $billController->getBillsByStatus('under review');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Bills</title>
</head>
<body>
    <h2>Bills Under Review</h2>
    <?php if (empty($billsUnderReview)): ?>
        <p>No bills are currently under review.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($billsUnderReview as $bill): ?>
                <tr>
                    <td><?php echo htmlspecialchars($bill['title']); ?></td>
                    <td><?php echo htmlspecialchars($bill['description']); ?></td>
                    <td><?php echo htmlspecialchars($bill['author']); ?></td>
                    <td><?php echo htmlspecialchars($bill['status']); ?></td>
                    <td>
                        <form action="approve_bill.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($bill['id']); ?>">
                            <button type="submit">Approve</button>
                        </form>
                        <form action="reject_bill.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($bill['id']); ?>">
                            <button type="submit">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
