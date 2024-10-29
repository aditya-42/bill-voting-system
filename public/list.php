<?php
require_once __DIR__ . '../../middleware/AuthMiddleware.php';
AuthMiddleware::requireAnyRole(['Member of Parliament', 'Reviewer', 'Administrator']);

require_once __DIR__ . '../../controllers/BillController.php';
$billController = new BillController();
$bills = $billController->getAllBills();

$userRole = $_SESSION['user']['role'];

require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill List</title>
    <link rel="stylesheet" href="../style.css"> 
</head>
<body>
    <main class="bill-list-page">
        <h2>All Bills</h2>
        <table class="bill-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Original Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(ucwords(strtolower($bill['title']))); ?></td>
                        <td><?php echo htmlspecialchars(ucwords(strtolower($bill['description']))); ?></td>
                        <td><?php echo htmlspecialchars(ucwords(strtolower($bill['author']))); ?></td>
                        <td><?php echo htmlspecialchars(ucwords(strtolower($bill['status']))); ?></td>
                        <td>
                            <div class="action-links">
                                <a class="action-link" href="edit.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Edit</a>
                                <a class="action-link" href="view_amendment.php?id=<?php echo htmlspecialchars($bill['id']); ?>">View Amendments</a>
                                <a class="action-link" href="amend.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Amend</a>
                                <a class="action-link" href="submit_bill.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Submit for Review</a>
                                <a class="action-link" href="vote.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Vote</a>
                                <a class="action-link" href="start_vote.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Start Vote</a>
                                <a class="action-link" href="view_results.php?id=<?php echo htmlspecialchars($bill['id']); ?>">View Results</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

  
</body>
</html>

<?php require_once '../views/footer.php'; ?>