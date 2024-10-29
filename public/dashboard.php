<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::requireAuth();

$userRole = $_SESSION['user']['role'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h1>
    <h2>Dashboard</h2>

    <?php if ($userRole === 'Member of Parliament'): ?>
        <section>
            <h3>Create New Bill</h3>
            <a href="create.php">Create Bill</a>
        </section>

        <section>
        <h3>View Bills</h3>
        <a href="bills.php">View Bills</a>

    </section>

    <?php endif; ?>

    <?php if ($userRole === 'Reviewer'): ?>
        <section>
        <h3>View Bills and suggest Amendments</h3>
        <a href="bills.php">View Bills</a>
    </section>
    <?php endif; ?>

    <?php if ($userRole === 'Administrator'): ?>
        <section>
        <h3>View Bills</h3>
        <a href="bills.php">View Bills</a>
    </section>

    <?php endif; ?>
</body>
</html>