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
    body {
      margin: 0;
      padding: 0;
      background: url('https://images.unsplash.com/photo-1601597111031-73f941f5f08b?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-box {
      background-color: rgba(255,255,255,0.97);
      padding: 40px;
      width: 100%;
      max-width: 600px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.15);
    }

    .form-box h2 {
      text-align: center;
      color: #1c3a57;
      margin-bottom: 25px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
      box-sizing: border-box;
    }

    textarea {
      resize: none;
      height: 100px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #1c3a57;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #102232;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #444;
    }
  </style>
</head>
<body>

<div class="form-box">
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
    <p><strong>Phone:</strong> 0798123456</p>
    <p><strong>Location:</strong> Green Park Avenue, Nairobi</p>
  </div>
</div>

</body>
</html>
