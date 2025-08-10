<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database credentials
    $host = "localhost";
    $dbname = "ict_consultancy";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Collect POST data
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $programs = $_POST['programs'] ?? '';
        $message = $_POST['message'] ?? '';

        // Validate
        if (!$fullname || !$email || !$phone || !$programs || !$message) {
            echo "<p style='color:red;'>❌ All fields are required.</p>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO admissions (fullname, email, phone, programs, mpesa_message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$fullname, $email, $phone, $programs, $message]);

            echo "<h2 style='color:green;'>✅ Your confirmation has been submitted successfully.</h2>";
            echo "<p>We will contact you shortly.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Admissions - ICT Consultancy</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f5;
      padding: 20px;
    }
    .container {
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #007b5e;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #218838;
    }
    .note {
      margin-top: 15px;
      background: #fff3cd;
      color: #856404;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📞 Contact Admissions Team</h2>
    <form method="POST" action="">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" required>

      <label for="programs">Select Program</label>
      <select id="programs" name="programs" required>
        <option value="">-- Choose a Program --</option>
        <option value="Graphic Design">Graphic Design</option>
        <option value="Mobile Application">Mobile Application</option>
        <option value="Web Design">Web Design</option>
        <option value="Cyber Security">Cyber Security</option>
        <option value="Computer Maintenance">Computer Maintenance</option>
        <option value="Employability Skills">Employability Skills</option>
      </select>

      <label for="message">M-Pesa Payment Confirmation Message (e.g., QWE123ABC Confirmed. Ksh 10,000 sent to ICT CONSULTANCY ...)</label>
      <textarea id="message" name="message" rows="4" required></textarea>

      <button type="submit">Submit Confirmation</button>

      <div class="note">
        📝 Example: <br> <code>QWE123ABC Confirmed. Ksh 10,000 sent to ICT CONSULTANCY on 17/07/2025 at 1:00PM.</code>
      </div>
    </form>
  </div>
</body>
</html>
