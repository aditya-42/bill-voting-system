<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../controllers/BillController.php';

session_start();
AuthMiddleware::checkLoggedIn();

// Check if the user has the 'Administrator' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: dashboard.php?error=not_authorized");
    exit();
}

$billController = new BillController();
$billId = $_POST['id'] ?? null;
$bill = $billController->getBillById($billId);

if (!$bill || $bill['status'] !== 'voting') {
    header("Location: dashboard.php?error=no_voting_in_progress");
    exit();
}

// Calculate results
$totalVotes = $bill['votes']['for'] + $bill['votes']['against'];
if ($bill['votes']['for'] > $bill['votes']['against']) {
    $billController->updateBillStatus($billId, 'passed');
} else {
    $billController->updateBillStatus($billId, 'rejected');
}

header("Location: dashboard.php?message=vote_calculated");
exit();
