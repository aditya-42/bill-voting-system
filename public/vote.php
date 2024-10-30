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


require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote on Bill</title>
    <link rel="stylesheet" href="../style.css"> 

    <style>
        .vote-page {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        .vote-page h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .vote-page form {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
         
        }

        .vote-page form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .vote-page button:hover {
            background-color: #0056b3;
        }

        .vote-page a {
            color: #007bff;
            text-decoration: none;
        }

        .vote-page a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="vote-page">
    <h2>Vote on Bill: <?php echo htmlspecialchars($bill['title']); ?></h2>
    <form method="POST">
        <button type="submit" name="vote" value="for">Vote For</button>
        <button type="submit" name="vote" value="against">Vote Against</button>
        <button type="submit" name="vote" value="abstain">Abstain</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
    </d>
</body>
</html>


<?php require_once '../views/footer.php'; ?>
