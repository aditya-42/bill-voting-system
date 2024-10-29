<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Administrator');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;

// Ensure the bill ID is provided
if (!$billId) {
    header("Location: dashboard.php?error=invalid_bill");
    exit();
}

// Fetch the bill and check its current status
$bill = $billController->getBillById($billId);
if (!$bill || $bill['status'] !== 'approved') {
    header("Location: dashboard.php?error=cannot_initiate_voting");
    exit();
}

// Update the bill status to 'voting'
$billController->initiateVoting($billId);

header("Location: dashboard.php?message=voting_started");
exit();
?>
