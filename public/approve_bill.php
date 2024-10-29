<?php
require_once __DIR__ . '/../controllers/BillController.php';

$billController = new BillController();
$billId = $_POST['id'] ?? null;

if ($billId) {
    $billController->approveBill($billId);
    header("Location: review_bills.php");
    exit();
}
header("Location: review_bills.php?error=invalid_bill");
