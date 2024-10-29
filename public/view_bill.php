<?php
require_once __DIR__ . '/../controllers/BillController.php';
$billController = new BillController();

$billId = $_GET['id'] ?? null;
$bill = $billController->getBillById($billId);


require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($bill['title']); ?></title>
    <link rel="stylesheet" href="../style.css"> 
</>
<body>
    <h2><?php echo htmlspecialchars($bill['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($bill['description'])); ?></p>
    <a href="amend.php?id=<?php echo $billId; ?>">Suggest an Amendment</a>
    <h3>Amendments</h3>
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
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>


<?php
require_once '../views/footer.php'; 
?>
