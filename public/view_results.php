<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Administrator');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);

if (!$billId) {
    die("Invalid bill ID.");
}

$results = $billController->calculateVoteResults($billId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Results</title>
</head>
<body>
    <h2>Voting Results</h2>

    <?php if ($results): ?>
        <table border="1">
            <tr>
                <th>Vote</th>
                <th>Count</th>
            </tr>
            <tr>
                <td>For</td>
                <td><?php echo $results['For']; ?></td>
            </tr>
            <tr>
                <td>Against</td>
                <td><?php echo $results['Against']; ?></td>
            </tr>
            <tr>
                <td>Abstain</td>
                <td><?php echo $results['Abstain']; ?></td>
            </tr>
        </table>
        <h3>Status: <?php echo htmlspecialchars($results['status']); ?></h3>
    <?php else: ?>
        <p>No results found for this bill.</p>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
