<?php
session_start();

// Initialize cart session if not set
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Product list
$products = [
    "laptop" => [
        "name" => "Laptop",
        "price" => 35000,
        "image" => "https://images.pexels.com/photos/18105/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=600"
    ],
    "smartphone" => [
        "name" => "Smartphone",
        "price" => 12000,
        "image" => "https://images.pexels.com/photos/607812/pexels-photo-607812.jpeg?auto=compress&cs=tinysrgb&w=600"
    ],
    "optic" => [
        "name" => "Optic Device (Projector)",
        "price" => 5000,
        "image" => "https://c8.alamy.com/comp/DCN1MN/optical-disk-and-cpu-DCN1MN.jpg"
    ]
];

// Handle Add to Cart and redirect
if (isset($_GET["add"])) {
    $product = $_GET["add"];
    if (isset($products[$product])) {
        $_SESSION["cart"][$product] = ($_SESSION["cart"][$product] ?? 0) + 1;
        header("Location: cart2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Purchase ICT Requirements</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }
    .container {
      background-color: rgba(0, 0, 0, 0.7);
      padding: 50px 20px;
      min-height: 100vh;
      text-align: center;
    }
    h1 {
      color: #00ffd9;
      margin-bottom: 30px;
    }
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      max-width: 1000px;
      margin: 0 auto;
    }
    .product {
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
    }
    .product img {
      max-width: 100%;
      height: 180px;
      border-radius: 8px;
      object-fit: cover;
    }
    .product h3, .product p {
      margin: 10px 0;
      color: #ffdb4d;
    }
    .buy-button {
      background-color: #00ffd9;
      color: #000;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .link-button {
      margin: 10px;
      display: inline-block;
      background-color: #ffaa00;
      color: #000;
      padding: 12px 25px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Purchase ICT Requirements</h1>

    <!-- Navigation Buttons (always visible) -->
    <a class="link-button" href="cart2.php">🛒 View Cart</a>
    <a class="link-button" href="checkout2.php">✅ Proceed to Checkout</a>
    <a class="link-button" href="admin_login3.php">📋 Admin Report</a>
    <a class="link-button" href="admissions.php">← Back to Admissions</a>

    <!-- Product Listing -->
    <div class="product-grid">
      <?php foreach ($products as $key => $item): ?>
        <div class="product">
          <img src="<?= $item["image"] ?>" alt="<?= $item["name"] ?>">
          <h3><?= $item["name"] ?> - KSH <?= number_format($item["price"]) ?></h3>
          <p>Essential device for ICT learning</p>
          <a class="buy-button" href="?add=<?= $key ?>">Add to Cart</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
