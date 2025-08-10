<?php
session_start();

$products = [
    "laptop" => ["name" => "Laptop", "price" => 35000],
    "smartphone" => ["name" => "Smartphone", "price" => 12000],
    "optic" => ["name" => "Optic Device", "price" => 5000]
];

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 50px;
    }
    h1 {
      color: #00ffd9;
    }
    table {
      margin: auto;
      width: 80%;
      border-collapse: collapse;
      background-color: rgba(255, 255, 255, 0.1);
    }
    th, td {
      padding: 12px;
      border: 1px solid #888;
    }
    th {
      background-color: #222;
    }
    .btn {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 24px;
      background-color: #ffaa00;
      color: #000;
      font-weight: bold;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <h1>Your Cart</h1>
  <?php if (empty($_SESSION["cart"])): ?>
    <p>Your cart is currently empty.</p>
  <?php else: ?>
    <table>
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price per Item</th>
        <th>Subtotal</th>
      </tr>
      <?php foreach ($_SESSION["cart"] as $key => $qty): ?>
        <?php
          $item = $products[$key];
          $subtotal = $qty * $item["price"];
          $total += $subtotal;
        ?>
        <tr>
          <td><?= $item["name"] ?></td>
          <td><?= $qty ?></td>
          <td>KSH <?= number_format($item["price"]) ?></td>
          <td>KSH <?= number_format($subtotal) ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <th colspan="3">Total Amount</th>
        <th>KSH <?= number_format($total) ?></th>
      </tr>
    </table>
    <a class="btn" href="checkout.php">Proceed to Checkout</a>
  <?php endif; ?>
  <br><br>
  <a class="btn" href="purchase_requirements.php">← Back to Shop</a>
</body>
</html>
