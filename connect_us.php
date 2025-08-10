<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "ict_connect_system");

    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $sql = "INSERT INTO connect_queries (name, email, phone, message)
            VALUES ('$name', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅ Message successfully sent!'); window.location.href='connect_us.php';</script>";
        exit();
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Connect With Us</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6); /* improved softer black overlay */
      z-index: 0;
    }

    .form-box {
      position: relative;
      z-index: 1;
      background-color: rgba(255,255,255,0.97);
      padding: 40px;
      max-width: 600px;
      width: 90%;
      border-radius: 15px;
      box-shadow: 0 0 30px rgba(0,0,0,0.25);
      text-align: center;
    }

    .form-box h2 {
      color: #1c3a57;
      text-align: center;
      margin-bottom: 25px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    textarea {
      resize: none;
      height: 100px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #1c3a57;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #14304d;
    }

    .footer {
      text-align: center;
      font-size: 14px;
      color: #222;
      margin-top: 25px;
    }

    .report-btn {
      background-color: #FFD700;
      color: #000;
      margin-top: 20px;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
    }

    .report-btn:hover {
      background-color: #e6c200;
    }

    .back-home {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: #fff;
      background-color: #1c3a57;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: bold;
    }

    .back-home:hover {
      background-color: #14304d;
    }

    @media (max-width: 600px) {
      .form-box {
        padding: 25px;
      }
    }
  </style>
</head>
<body>

<div class="form-box">
  <a href="Homepage.php" class="back-home">← Back to Homepage</a>

  <h2>Connect With Us</h2>
  <form method="POST" action="">
    <input type="text" name="name" placeholder="Your Full Name" required>
    <input type="email" name="email" placeholder="Your Email Address" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <textarea name="message" placeholder="Type your message..." required></textarea>
    <button type="submit">Send Message</button>
  </form>

  <div class="footer">
    <p><strong>Email:</strong> info@ictconnect.co.ke</p>
    <p><strong>Phone:</strong> 0724255124</p>
    <p><strong>Location:</strong> Green Park Avenue, Nairobi</p>
    <a href="connect_report.php" class="report-btn">📄 View Messages</a>
  </div>
</div>

</body>
</html>
