<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ict_purchases");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$products = [
    "laptop" => ["name" => "Laptop", "price" => 35000],
    "smartphone" => ["name" => "Smartphone", "price" => 12000],
    "optic" => ["name" => "Optic Device (Projector)", "price" => 5000]
];

if (!empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $key => $qty) {
        $item = $products[$key];
        $name = $item["name"];
        $price = $item["price"] * $qty;
        $stmt = $conn->prepare("INSERT INTO purchases (product_name, quantity, total_price) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $name, $qty, $price);
        $stmt->execute();
    }
    $_SESSION["cart"] = []; // clear cart
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Checkout Complete</title>
  <style>
    body { font-family: Arial; text-align: center; padding: 100px; background: #e0ffe0; }
    .box {
      background: white;
      padding: 40px;
      display: inline-block;
      border-radius: 12px;
      box-shadow: 0 0 12px #aaa;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>✅ Order Placed Successfully</h2>
    <p>Please pay <strong>via M-Pesa: 0724255124</strong></p>
    <p>Use your name as reference.</p>
    <a href="shop2.php">← Back to Shop</a>
  </div>
</body>
</html>
