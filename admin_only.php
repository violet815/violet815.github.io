<?php
session_start();

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin@123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: user_registration_report.php");
        exit();
    } else {
        $error = "❌ Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Only Login</title>
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1543269865-cbf427effbad') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }
        .login-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 10px;
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
        }
        button {
            padding: 10px 20px;
            background-color: #ffd700;
            color: black;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .error {
            color: #ff6961;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 Admin Only Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
