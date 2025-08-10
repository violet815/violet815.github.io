<?php
session_start();

$products = [
    "laptop" => [
        "name" => "Laptop",
        "price" => 35000,
        "image" => "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=compress&cs=tinysrgb&w=600"
    ],
    "smartphone" => [
        "name" => "Smartphone",
        "price" => 12000,
        "image" => "https://images.pexels.com/photos/607812/pexels-photo-607812.jpeg?auto=compress&cs=tinysrgb&w=600"
    ],
    "optic" => [
        "name" => "Optic Device",
        "price" => 5000,
        "image" => "https://images.pexels.com/photos/729030/pexels-photo-729030.jpeg?auto=compress&cs=tinysrgb&w=600"
    ]
];

$total = 0;
$cart = $_SESSION["cart"] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <style>
    body {
      background-color: #000;
      color: #00ffd9;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 40px;
    }
    .box {
      background-color: #111;
      padding: 40px;
      border-radius: 10px;
      display: inline-block;
      box-shadow: 0 0 20px rgba(0,255,255,0.3);
      max-width: 900px;
      width: 100%;
    }
    h1 {
      margin-bottom: 20px;
    }
    p {
      color: #fff;
      font-size: 1.1em;
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
    .product-list {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      margin-top: 30px;
    }
    .product {
      background: rgba(255,255,255,0.05);
      padding: 15px;
      border-radius: 10px;
      width: 220px;
      color: #fff;
      box-shadow: 0 0 10px rgba(255,255,255,0.1);
    }
    .product img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
    }
    .caption {
      margin-top: 10px;
      color: #ffdb4d;
      font-size: 1em;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>Payment Instructions</h1>

    <?php if (empty($cart)): ?>
      <p>Your cart is empty. Please <a href="purchase_requirements.php" style="color:#ffaa00;">go back</a> and select items.</p>
    <?php else: ?>
      <div class="product-list">
        <?php foreach ($cart as $key => $qty): ?>
          <?php if (isset($products[$key])): ?>
            <?php
              $product = $products[$key];
              $subtotal = $qty * $product['price'];
              $total += $subtotal;
            ?>
            <div class="product">
              <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
              <div class="caption">
                <strong><?= $product['name'] ?></strong><br>
                Qty: <?= $qty ?><br>
                Subtotal: KSH <?= number_format($subtotal) ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

      <p style="margin-top: 30px;"><strong>Total Amount:</strong> KSH <?= number_format($total) ?></p>
      <p>To complete your purchase, please pay via:</p>
      <p><strong>M-Pesa Number:</strong> <span style="color: #ffdb4d;">0724255124</span></p>
      <p><strong>Reference:</strong> Use your full name</p>
      <p>After payment, your order will be processed and delivered.</p>
      <a class="btn" href="purchase_requirements.php">← Back to Shop</a>
    <?php endif; ?>
  </div>

  <?php session_destroy(); ?>
</body>
</html>
