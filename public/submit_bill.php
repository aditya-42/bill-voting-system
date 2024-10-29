<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireRole('Reviewer');

require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);

// Ensure the bill ID is provided
if (!$billId) {
    header("Location: list.php?error=invalid_bill");
    exit();
}

if (!$bill || $bill['status'] !== 'Draft') {
    header("Location: dashboard.php?error=not_draft");
    exit();
}

// Update the bill status to 'under review'
$billController->submitForReview($billId);

header("Location: dashboard.php?message=bill_submitted");
exit();
?>
