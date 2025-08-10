<?php
session_start();

// --- Handle Admin Logout ---
if (isset($_GET['admin_logout'])) {
    unset($_SESSION['admin_logged_in']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "ict_admissions_access");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$signupMsg = "";
$approvalMsg = "";
$loginMsg = "";

// --- Flash Messages ---
if (isset($_SESSION['signup_success'])) {
    $signupMsg = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']);
}
if (isset($_SESSION['approval_success'])) {
    $approvalMsg = $_SESSION['approval_success'];
    unset($_SESSION['approval_success']);
}

// --- Handle Signup ---
if (isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, approved) VALUES (?, ?, ?, 0)");
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $_SESSION['signup_success'] = "✅ Signup successful! Please wait for admin approval.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $signupMsg = "❌ Signup failed: Email may already exist.";
        }
        $stmt->close();
    } else {
        $signupMsg = "❌ Signup error: " . $conn->error;
    }
}

// --- Handle Login ---
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, approved FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $name, $hashedPassword, $approved);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                if ($approved == 1) {
                    $_SESSION['user'] = ['id' => $userId, 'name' => $name, 'email' => $email];
                    header("Location: programs.php");
                    exit();
                } else {
                    $loginMsg = "⏳ Your account is pending approval by admin.";
                }
            } else {
                $loginMsg = "❌ Incorrect password.";
            }
        } else {
            $loginMsg = "❌ No user found with this email.";
        }
        $stmt->close();
    } else {
        $loginMsg = "❌ Login error: " . $conn->error;
    }
}

// --- Admin Authentication ---
if (isset($_POST['admin_login'])) {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    if ($admin_username === "admin" && $admin_password === "admin@123") {
        $_SESSION['admin_logged_in'] = true;
        $approvalMsg = "✅ Admin authenticated. You can now approve users.";
    } else {
        $approvalMsg = "❌ Invalid admin credentials.";
    }
}

// --- Admin Approval ---
if (isset($_POST['admin_approve']) && isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $emailToApprove = $_POST['admin_email'];
    $stmt = $conn->prepare("UPDATE users SET approved = 1 WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $emailToApprove);
        if ($stmt->execute()) {
            $_SESSION['approval_success'] = "✅ Approved: $emailToApprove";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $approvalMsg = "❌ Approval failed.";
        }
        $stmt->close();
    } else {
        $approvalMsg = "❌ Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ICT Admissions Portal</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      color: white;
      background: url('https://tse1.mm.bing.net/th/id/OIP.bHQ7R22Q500NNMbvYcoAzwHaE8') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 80px auto;
      background: rgba(0,0,0,0.75);
      padding: 30px;
      border-radius: 12px;
    }
    a.back-button {
      display: inline-block;
      margin-bottom: 15px;
      background: #00CC99;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
    }
    h2, h3 {
      text-align: center;
      color: #00FFCC;
    }
    form {
      margin-top: 20px;
    }
    input[type=text], input[type=email], input[type=password] {
      width: 100%;
      padding: 12px;
      margin: 8px 0 16px;
      border: none;
      border-radius: 6px;
    }
    input[type=submit] {
      background-color: #00CC99;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
    }
    .message {
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="Homepage.php" class="back-button">← Back to Homepage</a>
    <h2>ICT Admissions Portal</h2>

    <!-- Signup Form -->
    <form method="post">
      <h3>Create an Account</h3>
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email Address" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="submit" name="signup" value="Sign Up" />
    </form>
    <div class="message"><?= $signupMsg ?></div>

    <!-- Login Form -->
    <form method="post">
      <h3>Sign In</h3>
      <input type="email" name="email" placeholder="Email Address" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="submit" name="login" value="Sign In to Access Programs" />
    </form>
    <div class="message"><?= $loginMsg ?></div>

    <!-- Admin Login -->
    <?php if (!isset($_SESSION['admin_logged_in'])): ?>
    <form method="post" style="margin-top:30px;">
      <h3>Admin Login (Required for Approval)</h3>
      <input type="text" name="admin_username" placeholder="Admin Username" required />
      <input type="password" name="admin_password" placeholder="Admin Password" required />
      <input type="submit" name="admin_login" value="Login as Admin" />
    </form>
    <?php endif; ?>

    <!-- Admin Approval + Logout -->
    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
    <form method="post" style="margin-top:30px;">
      <h3>Approve a User</h3>
      <input type="email" name="admin_email" placeholder="User Email to Approve" required />
      <input type="submit" name="admin_approve" value="Approve User" />
    </form>

    <!-- Admin Logout Button -->
    <form method="get" style="margin-top:15px;">
      <input type="submit" name="admin_logout" value="🚪 Logout Admin" style="background-color:#cc3333; color:white; padding:10px; border:none; border-radius:6px; width:100%; cursor:pointer;" />
    </form>
    <?php endif; ?>

    <div class="message"><?= $approvalMsg ?></div>
  </div>
  <!-- ...everything above remains unchanged -->

    <div class="message"><?= $approvalMsg ?></div>

    <!-- 📞 Enhanced Support Message -->
    <div style="background-color:#d4edda; color:#ff5722; text-align:center; font-weight:bold; 
                font-size:16px; margin-top:30px; padding:15px; border-radius:8px; box-shadow:0 0 12px rgba(0,0,0,0.25);">
        📞 Having an issue? Contact Phone: <strong>0724255124</strong>
    </div>
    
  </div>
</body>
</html>

</body>

</html>
