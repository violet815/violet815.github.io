<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ict_purchases");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter_product = $_GET['product'] ?? '';
$filter_start_date = $_GET['start_date'] ?? '';
$filter_end_date = $_GET['end_date'] ?? '';

$query = "SELECT product_name, quantity, total_price, purchase_date FROM purchases WHERE 1";

if (!empty($filter_product)) {
    $query .= " AND product_name LIKE '%" . $conn->real_escape_string($filter_product) . "%'";
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
            font-family: Arial;
            background: #f2f2f2;
            padding: 30px;
        }
        h2 {
            text-align: center;
            color: #004080;
        }
        .filter-form {
            text-align: center;
            margin-bottom: 30px;
        }
        .filter-form input {
            padding: 8px;
            margin: 5px;
            width: 200px;
        }
        .filter-form button {
            padding: 10px 20px;
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #004080;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>🛒 Purchase Report</h2>

<div class="filter-form">
    <form method="get">
        <input type="text" name="product" placeholder="Search Product" value="<?= htmlspecialchars($filter_product) ?>">
        <input type="date" name="start_date" value="<?= htmlspecialchars($filter_start_date) ?>">
        <button type="submit">Apply Filters</button>
        <a href="purchase_report.php" style="margin-left:10px; text-decoration:none; color:#004080;"></a>
        <a class="back-btn" href="javascript:history.back()">← Back</a>
    </form>
</div>

<table>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total (KSH)</th>
        <th>Purchase Date</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= number_format($row['total_price']) ?></td>
                <td><?= htmlspecialchars($row['purchase_date']) ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">No purchases found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>


