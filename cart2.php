<?php
session_start();
$products = [
    "laptop" => ["name" => "Laptop", "price" => 35000],
    "smartphone" => ["name" => "Smartphone", "price" => 12000],
    "optic" => ["name" => "Optic Device (Projector)", "price" => 5000]
];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Cart</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; text-align: center; padding: 50px; }
    table { width: 80%; margin: auto; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 12px; }
    th { background: #00ffd9; color: black; }
    .btn { background: #ffaa00; padding: 10px 20px; border-radius: 6px; text-decoration: none; color: black; font-weight: bold; margin: 10px; display: inline-block; }
  </style>
</head>
<body>
<h2>🛒 Your Cart</h2>
<?php if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])): ?>
  <p>Your cart is empty.</p>
  <a class="btn" href="shop2.php">← Back to Shop</a>
<?php else: ?>
  <table>
    <tr><th>Product</th><th>Quantity</th><th>Total (KSH)</th></tr>
    <?php
    $grand_total = 0;
    foreach ($_SESSION["cart"] as $key => $qty):
        $item = $products[$key];
        $total = $item["price"] * $qty;
        $grand_total += $total;
    ?>
    <tr>
      <td><?= $item["name"] ?></td>
      <td><?= $qty ?></td>
      <td><?= number_format($total) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <th colspan="2">Grand Total</th>
      <th><?= number_format($grand_total) ?></th>
    </tr>
  </table>
  <a class="btn" href="checkout2.php">✅ Proceed to Checkout</a>
  <a class="btn" href="shop2.php">← Continue Shopping</a>
<?php endif; ?>
</body>
</html>
