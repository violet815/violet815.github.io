<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ict_admissions_access");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT name, paid FROM users WHERE id = $user_id")->fetch_assoc();

if ($user['paid'] == 1) {
    header("Location: programs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Make Payment</title>
  <style>
    body {
      background: #f4f4f4;
      font-family: Arial;
      text-align: center;
      padding-top: 100px;
    }

    .payment-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px #ccc;
      width: 350px;
      margin: auto;
    }

    button {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="payment-box">
    <h2>Hi <?= htmlspecialchars($user['name']) ?> 👋</h2>
    <p>You need to complete payment to access the training programs.</p>
    <p><strong>Payment: KES 500</strong></p>

    <!-- Simulated Payment Button -->
    <form method="post">
      <button type="submit" name="pay">Pay Now</button>
    </form>
  </div>

  <?php
  if (isset($_POST['pay'])) {
      // Simulated payment success
      $conn->query("UPDATE users SET paid = 1 WHERE id = $user_id");
      echo "<script>alert('✅ Payment successful! You now have access.'); window.location.href='programs.php';</script>";
      exit();
  }
  ?>
</body>
</html>
