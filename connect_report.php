<?php
session_start();

// Hardcoded credentials
$admin_username = "admin";
$admin_password = "admin@123";

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: connect_report.php");
        exit();
    } else {
        $error = "❌ Invalid credentials";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: connect_report.php");
    exit();
}
?>

<?php if (!isset($_SESSION['admin_logged_in'])): ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('https://images.unsplash.com/photo-1581091012184-5c4bfb2b8cc4?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(28, 58, 87, 0.75);
      z-index: 0;
    }
    .login-box {
      position: relative;
      z-index: 1;
      background: rgba(255,255,255,0.95);
      padding: 40px;
      width: 300px;
      margin: 100px auto;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      text-align: center;
    }
    h2 {
      color: #1c3a57;
      margin-bottom: 20px;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #1c3a57;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #14304d;
    }
    .error {
      color: red;
      margin-top: 10px;
    }
    .back-link {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #1c3a57;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Admin Login</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login" type="submit">Login</button>
    <?php if (isset($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
  </form>
  <a class="back-link" href="connect_us.php">← Back to Contact Page</a>
</div>

</body>
</html>

<?php else: ?>

<?php
$conn = new mysqli("localhost", "root", "", "ict_connect_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM connect_queries ORDER BY date_sent DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submitted Messages Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 40px;
      background: url('https://images.unsplash.com/photo-1581091012184-5c4bfb2b8cc4?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(28, 58, 87, 0.75);
      z-index: 0;
    }
    .container {
      position: relative;
      z-index: 1;
      background-color: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      max-width: 95%;
      margin: auto;
    }
    h2 {
      color: #1c3a57;
      text-align: center;
      margin-bottom: 25px;
    }
    #searchInput {
      display: block;
      margin: 0 auto 20px auto;
      padding: 10px;
      width: 50%;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background: white;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #1c3a57;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .btns {
      text-align: center;
      margin-top: 25px;
    }
    .btns a {
      display: inline-block;
      padding: 10px 20px;
      background: #1c3a57;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      margin: 0 10px;
    }
    .btns a:hover {
      background-color: #102232;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>📩 Submitted Messages</h2>

  <!-- Search input -->
  <input type="text" id="searchInput" placeholder="🔍 Search any field...">

  <table id="reportTable">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Message</th>
      <th>Date Sent</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['message']) ?></td>
      <td><?= $row['date_sent'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <div class="btns">
    <a href="connect_us.php">← Back to Contact Page</a>
    <a href="connect_report.php?logout=1">🚪 Logout</a>
  </div>
</div>

<!-- Search script -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
  const value = this.value.toLowerCase();
  const rows = document.querySelectorAll("#reportTable tr:not(:first-child)");
  rows.forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
  });
});
</script>

</body>
</html>

<?php endif; ?>
