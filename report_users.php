<?php
session_start();

// Hardcoded admin credentials
$valid_admin = "admin";
$valid_password = "admin@123";

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: report_users.php");
    exit();
}

// Handle admin login
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $valid_admin && $password === $valid_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "❌ Incorrect admin credentials.";
    }
}
?>

<?php if (!isset($_SESSION['admin_logged_in'])): ?>
<!-- ADMIN LOGIN FORM -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }
        .login-box {
            background: #fff;
            padding: 30px;
            max-width: 400px;
            margin: 80px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .back-home {
            position: absolute;
            top: -40px;
            left: 0;
            display: inline-block;
            text-decoration: none;
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-home:hover {
            background-color: #1e8449;
        }
    </style>
</head>
<body>
<div class="login-box">
    <a class="back-home" href="homepage.php">← Back to Homepage</a>
    <h2>🔐 Admin Login</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Admin name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login" type="submit">Login</button>
    </form>
</div>
</body>
</html>

<?php else: ?>
<?php
require 'db.php';

// Handle search input
$search = $_GET['search'] ?? '';

// Count users
$countQuery = "SELECT COUNT(*) AS total FROM users";
$countResult = $conn->query($countQuery);
$totalUsers = $countResult->fetch_assoc()['total'];

// Search query if search term is provided
if (!empty($search)) {
    $searchTerm = "%" . $conn->real_escape_string($search) . "%";
    $userQuery = $conn->prepare("
        SELECT firstname, lastname, email, created_at 
        FROM users 
        WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ? OR created_at LIKE ?
        ORDER BY created_at DESC
    ");
    $userQuery->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
} else {
    $userQuery = "SELECT firstname, lastname, email, created_at FROM users ORDER BY created_at DESC";
    $userResult = $conn->query($userQuery);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef3f7;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
        }
        .summary {
            background: #dff9fb;
            padding: 10px;
            border-left: 5px solid #3498db;
            margin-bottom: 20px;
            font-size: 18px;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box form {
            display: flex;
            max-width: 400px;
        }
        .search-box input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }
        .search-box button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background: #3498db;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #2980b9;
            color: white;
        }
        .back-button, .logout-button, .home-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .logout-button {
            background-color: #e74c3c;
        }
        .home-button {
            background-color: #8e44ad;
        }
        .back-button:hover {
            background-color: #1e8449;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
        .home-button:hover {
            background-color: #732d91;
        }
    </style>
</head>
<body>

    <a href="homepage.php" class="home-button">← Back to Homepage</a>
    <a href="?logout=1" class="logout-button">🚪 Logout</a>

    <h1>📊 User Signup Report</h1>

    <div class="summary">
        <strong>Total Registered Users:</strong> <?php echo $totalUsers; ?>
    </div>

   <div class="search-box">
    <form method="get" style="display: flex;">
        <input type="text" name="search" placeholder="Search by name, email, or date..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">🔍 Search</button>
        <a href="report_users.php" style="text-decoration: none;">
            <button type="button" style="margin-left: 10px; background-color: #16a085;">🔄 Refresh</button>
        </a>
    </form>
</div>

        </form>
    </div>

    <table>
        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Signup Date</th>
        </tr>
        <?php
        if ($userResult->num_rows > 0) {
            while ($row = $userResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php $conn->close(); ?>
<?php endif; ?>
