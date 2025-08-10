<?php
session_start();

$admin_user = "admin";
$admin_pass = "admin@123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION["is_admin"] = true;
        header("Location: purchase_report2.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('https://images.unsplash.com/photo-1581093588401-a1d4e7b9b046?auto=compress&cs=tinysrgb&dpr=2&h=1000&w=1600') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background: rgba(0, 0, 0, 0.75);
      color: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
      width: 320px;
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #00ffd9;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: none;
      border-radius: 6px;
      background: #f1f1f1;
    }
    input[type="submit"] {
      background: #ffaa00;
      color: black;
      padding: 12px;
      width: 100%;
      border: none;
      font-weight: bold;
      cursor: pointer;
      border-radius: 6px;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
    .back-button {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #00ffd9;
      text-decoration: none;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>🔐 Admin Login</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Admin Username" required>
      <input type="password" name="password" placeholder="Admin Password" required>
      <input type="submit" value="Login">
    </form>
    <a class="back-button" href="shop2.php">← Back to Shop</a>
  </div>
</body>
</html>
