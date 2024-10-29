<?php
require_once __DIR__ . '../../middleware/AuthMiddleware.php';
AuthMiddleware::requireAnyRole(['Member of Parliament', 'Reviewer', 'Administrator']);

require_once __DIR__ . '../../controllers/BillController.php';
$billController = new BillController();
$bills = $billController->getAllBills();

$userRole = $_SESSION['user']['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bill List</title>
</head>
<body>
    <h2>All Bills</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Original Author</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($bills as $bill): ?>
        
        <tr>
            <td><?php echo htmlspecialchars($bill['title']); ?></td>
            <td><?php echo htmlspecialchars($bill['description']); ?></td>
            <td><?php echo htmlspecialchars($bill['author']); ?></td>
            <td><?php echo htmlspecialchars($bill['status']); ?></td>
            <td>
                <a href="edit.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Edit Bill</a>
                <a href="view_amendment.php?id=<?php echo htmlspecialchars($bill['id']); ?>">View Amendments</a>
                <a href="amend.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Amend Bill</a>
                <a href="submit_bill.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Submit Bill for Review</a>
                <a href="vote.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Vote</a>    
                <a href="start_vote.php?id=<?php echo htmlspecialchars($bill['id']); ?>">Start Vote</a>   
                <a href="view_results.php?id=<?php echo htmlspecialchars($bill['id']); ?>">View results</a>
                
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
