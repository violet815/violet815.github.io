<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ict_purchases");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin login check
$admin_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin@123') {
        $_SESSION['admin_logged_in'] = true;
        $admin_logged_in = true;
    } else {
        $login_error = "Invalid credentials. Please try again.";
    }
}

// If not logged in, show login form only
if (!$admin_logged_in):
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/bg-purchase.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
        }

        .login-container {
            width: 400px;
            margin: 150px auto;
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            border: 1px solid #aaa;
        }

        button {
            background-color: #006699;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Enter admin username" required><br>
            <input type="password" name="password" placeholder="Enter password" required><br>
            <button type="submit" name="admin_login">Login</button>
        </form>
    </div>
</body>
</html>
<?php
exit;
endif;

// --- FETCH FILTERS & QUERY ---
$filter_product = $_GET['product'] ?? '';
$filter_start_date = $_GET['start_date'] ?? '';
$filter_end_date = $_GET['end_date'] ?? '';

$query = "SELECT product_name, quantity, total_price, purchase_date FROM purchases WHERE 1=1";

if (!empty($filter_product)) {
    $query .= " AND product_name = '" . $conn->real_escape_string($filter_product) . "'";
}
if (!empty($filter_start_date)) {
    $query .= " AND purchase_date >= '" . $conn->real_escape_string($filter_start_date) . "'";
}
if (!empty($filter_end_date)) {
    $query .= " AND purchase_date <= '" . $conn->real_escape_string($filter_end_date) . "'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/bg-purchase.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
        }

        .container {
            width: 95%;
            margin: 50px auto;
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #006699;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #006699;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #liveSearch {
            padding: 10px;
            width: 60%;
            margin: 20px auto;
            display: block;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .refresh-btn {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .refresh-btn:hover {
            background-color: #218838;
        }

        .back-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Purchase Report</h2>

    <!-- Refresh Button -->
    <form method="get" action="purchase_report2.php">
        <button type="submit" class="refresh-btn">🔄 Refresh</button>
    </form>

    <!-- Back to Admin -->
    <form action="admin_login3.php" method="get" style="text-align:center;">
        <button class="back-btn">⬅ Back to Admin</button>
    </form>

    <!-- Live Search -->
    <input type="text" id="liveSearch" placeholder="🔍 Search any value in the table...">

    <!-- Table -->
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price (KES)</th>
            <th>Purchase Date</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td><?= htmlspecialchars($row['total_price']) ?></td>
            <td><?= htmlspecialchars($row['purchase_date']) ?></td>
        </tr>
        <?php
            endwhile;
        else:
        ?>
        <tr><td colspan="4">No purchases found.</td></tr>
        <?php endif; ?>
    </table>
</div>

<!-- JavaScript for Live Search -->
<script>
document.getElementById("liveSearch").addEventListener("keyup", function () {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll("table tr:not(:first-child)");
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
    });
});
</script>
</body>
</html>
