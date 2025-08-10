<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ict_admissions_access");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Signup
$signupMsg = "";
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, paid) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $signupMsg = "<span style='color: green;'>Signup successful. Please login.</span>";
    } else {
        $signupMsg = "<span style='color: red;'>Signup failed. Email may already be used.</span>";
    }
    $stmt->close();
}

// Handle Login
$loginMsg = "";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, paid FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password, $paid);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['paid'] = $paid;
            header("Location: program_access_portal.php?action=access");
            exit();
        } else {
            $loginMsg = "<span style='color: red;'>Invalid password.</span>";
        }
    } else {
        $loginMsg = "<span style='color: red;'>Email not found.</span>";
    }
    $stmt->close();
}

// Handle Payment Update
if (isset($_GET['pay']) && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $sql = "UPDATE users SET paid = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $_SESSION['paid'] = 1;
    header("Location: program_access_portal.php?action=access");
    exit();
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: program_access_portal.php");
    exit();
}

// Display Program Access Page
if (isset($_GET['action']) && $_GET['action'] == 'access') {
    if (!isset($_SESSION['user_id'])) {
        echo "<p>Please <a href='program_access_portal.php'>login</a> first.</p>";
        exit();
    }

    echo "
    <h2>🎓 Welcome to the ICT Consultancy Program</h2>
    <p>Hello, User #" . $_SESSION['user_id'] . "</p>";

    if ($_SESSION['paid']) {
        echo "
        <div style='background:#e6ffe6;padding:20px;border-radius:10px;'>
            <h3 style='color:green;'>✅ Access Granted</h3>
            <p>You now have full access to all ICT Consultancy learning materials.</p>
            <ul>
                <li><a href='web_design.php'>Web Design</a></li>
                <li><a href='mobile_app.php'>Mobile Application Development</a></li>
                <li><a href='cybersecurity.php'>Cybersecurity Training</a></li>
                <li><a href='maintenance.php'>Computer Maintenance</a></li>
            </ul>
        </div>";
    } else {
        echo "
        <div style='background:#fff8e6;padding:20px;border-radius:10px;'>
            <h3 style='color:orange;'>⚠ Access Restricted</h3>
            <p>You need to pay before accessing the program.</p>
            <p>Pay KES 1,000 via M-PESA to <strong>0724255124</strong>.</p>
            <a href='program_access_portal.php?pay=true' style='color:white;background:green;padding:10px 20px;border-radius:5px;text-decoration:none;'>I Have Paid</a>
        </div>";
    }

    echo "<p><a href='program_access_portal.php?logout=true'>Logout</a></p>";
    exit();
}
?>

<!-- Signup Form -->
<h2>📝 Signup</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="signup">Signup</button>
</form>
<?php echo $signupMsg; ?>

<hr>

<!-- Login Form -->
<h2>🔐 Login</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>
<?php echo $loginMsg; ?>
