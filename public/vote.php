<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../controllers/BillController.php';

AuthMiddleware::requireRole('Member of Parliament');


$billController = new BillController();
$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);

// Ensure the bill is in voting status
if (!$bill || $bill['status'] !== 'voting') {
    header("Location: dashboard.php?error=voting_not_available");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vote = $_POST['vote'] ?? null;
    if (in_array($vote, ['for', 'against', 'abstain'])) {
        $billController->recordVote($billId, $vote);
        header("Location: dashboard.php?message=vote_cast");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote on Bill</title>
</head>
<body>
    <h2>Vote on Bill: <?php echo htmlspecialchars($bill['title']); ?></h2>
    <form method="POST">
        <button type="submit" name="vote" value="for">Vote For</button>
        <button type="submit" name="vote" value="against">Vote Against</button>
        <button type="submit" name="vote" value="abstain">Abstain</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
