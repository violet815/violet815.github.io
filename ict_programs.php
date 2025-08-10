<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ict_consultancy_portal");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle signup
$signupMsg = '';
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $paid = isset($_POST['paid']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, paid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $password, $paid);
    if ($stmt->execute()) {
        $signupMsg = "✅ Signup successful. You can now log in.";
    } else {
        $signupMsg = "❌ Error during signup.";
    }
    $stmt->close();
}

// Handle login
$loginMsg = '';
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT id, name, password, paid FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $name, $hashed_password, $paid);
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_paid'] = $paid == 1;
        $_SESSION['logged_in'] = true;
        header("Location: program_access.php");
        exit();
    } else {
        $loginMsg = "❌ Invalid credentials.";
    }
    $stmt->close();
}

// Redirect if not logged in
if (!isset($_SESSION['logged_in'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>ICT Programs Access</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 30px; }
        .form-container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
        h2 { text-align: center; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 10px; margin: 5px 0 15px; border-radius: 5px; border: 1px solid #ccc;
        }
        input[type="submit"] {
            background: #28a745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .msg { text-align: center; margin: 10px 0; color: green; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Sign Up</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="paid"> I have paid</label><br><br>
        <input type="submit" name="signup" value="Sign Up">
    </form>
    <div class="msg"><?= $signupMsg ?></div>
</div>

<div class="form-container" style="margin-top:30px;">
    <h2>Login</h2>
    <form method="post">
        <input type="email" name="login_email" placeholder="Email Address" required>
        <input type="password" name="login_password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
    </form>
    <div class="error"><?= $loginMsg ?></div>
</div>
</body>
</html>
<?php
exit();
}

// Logged-in user & paid
if ($_SESSION['user_paid']) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>ICT Programs</title>
    <style>
        body { font-family: Arial; background: #222; color: white; margin: 0; padding: 0; }
        .container { padding: 30px; max-width: 900px; margin: auto; }
        h1, h2 { text-align: center; }
        .program { background: #333; margin: 20px 0; padding: 15px; border-radius: 10px; }
        a.btn {
            display: inline-block; padding: 10px 15px; background: #28a745;
            color: white; text-decoration: none; border-radius: 5px;
        }
        a.btn:hover { background: #218838; }
        .logout { background: #dc3545; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
        <h2>ICT Programs Access</h2>

        <div class="program">
            <h3>Web Design</h3>
            <p>Learn HTML, CSS, JavaScript to create stunning websites.</p>
            <a href="#" class="btn">Start Web Design</a>
        </div>

        <div class="program">
            <h3>Mobile App Development</h3>
            <p>Develop Android and iOS apps using Android Studio and Flutter.</p>
            <a href="#" class="btn">Start Mobile App</a>
        </div>

        <div class="program">
            <h3>Cybersecurity</h3>
            <p>Understand online security, threats and how to prevent them.</p>
            <a href="#" class="btn">Start Cybersecurity</a>
        </div>

        <form method="post" class="logout">
            <input type="submit" name="logout" value="Logout" style="padding:10px; background:#dc3545; color:white; border:none; border-radius:5px;">
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo "<h2 style='text-align:center;color:red;margin-top:100px;'>⛔ Access Denied: Please complete payment to access programs.</h2>";
    echo "<p style='text-align:center;'><a href='payment_page.php'>Go to Payment Page</a></p>";
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: program_access.php");
    exit();
}
?>
