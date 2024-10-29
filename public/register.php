<?php
require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registrationSuccess = $authController->register($_POST['username'], $_POST['password'], $_POST['role']);
    if ($registrationSuccess) {
        // Redirect with a success message
        header("Location: login.php?message=Registration successful! Please log in.");
        exit();
    } else {
        $message = "Registration failed. Please try again.";
    }
}

require_once '../views/header.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Optional: for icon -->
    <style>
        /* Toast message styles */
        .toast {
            position: block;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            display: none; /* Hidden by default */
            animation: fadeIn 0.5s, fadeOut 0.5s 3.5s; /* Animation */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>
    <main class="register-page">
        <h2>Register</h2>
        <form method="post">
            <label>Username: <input type="text" name="username" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <label>Role: 
                <select name="role">
                    <option value="Member of Parliament">Member of Parliament</option>
                    <option value="Reviewer">Reviewer</option>
                    <option value="Administrator">Administrator</option>
                </select>
            </label><br>
            <button type="submit">Register</button>
        </form>
        <p><?php echo htmlspecialchars($message); ?></p>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="toast"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>
        
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>

    <script>
        // Show toast message if it exists
        const toast = document.querySelector('.toast');
        if (toast) {
            toast.style.display = 'block'; // Show the toast
            setTimeout(() => {
                toast.style.display = 'none'; // Hide after some time
            }, 4000); // Display for 4 seconds
        }
    </script>
</body>
</html>

<?php
require_once '../views/footer.php'; 
?>
