<?php
session_start();

// For testing: Set a dummy user_id in session manually (remove after real login setup)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Example user id - replace with actual after login
}

require 'web2.php';

$formMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['program'])) {
    $user_id = $_SESSION['user_id'];
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $program = $_POST['program'];
    $interest = $_POST['interest'] ?? '';
    $expectations = $_POST['expectations'] ?? '';
    $challenges = $_POST['challenges'] ?? '';
    $suggestions = $_POST['suggestions'] ?? '';

    if ($program !== '' && $fullname !== '' && $email !== '') {
        $sql = "INSERT INTO program_forms (user_id, fullname, email, program, interest, expectations, challenges, suggestions) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isssssss", $user_id, $fullname, $email, $program, $interest, $expectations, $challenges, $suggestions);
            if ($stmt->execute()) {
                $formMessage = "✅ Form submitted successfully.";
            } else {
                $formMessage = "❌ Error executing statement: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $formMessage = "❌ Error preparing statement: " . $conn->error;
        }
    } else {
        $formMessage = "⚠️ Please complete all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>ICT Program Feedback Form</title>
  <style>
    /* your existing styles here */
    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c') no-repeat center center fixed;
      background-size: cover;
      color: white;
      margin: 0;
    }
    .overlay {
      background-color: rgba(0, 0, 0, 0.75);
      padding: 50px 20px;
      min-height: 100vh;
    }
    .form-section {
      max-width: 800px;
      margin: auto;
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
      position: relative;
    }
    h2 {
      text-align: center;
      color: #ffd700;
    }
    label {
      display: block;
      margin: 15px 0 5px;
      font-weight: bold;
    }
    select, textarea, input[type="text"], input[type="email"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: none;
      margin-bottom: 10px;
    }
    button {
      background-color: #ffd700;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    .message {
      text-align: center;
      color: #00ffcc;
      font-weight: bold;
      margin-top: 10px;
    }
    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
    }
    .back-button a {
      background: #ffd700;
      padding: 10px 15px;
      border-radius: 5px;
      color: black;
      font-weight: bold;
      text-decoration: none;
    }
  </style>
</head>
<body>
<div class="overlay">
  <div class="form-section">
    <div class="back-button">
      <a href="programs.php">← Back to Programs</a>
    </div>
    <h2>📝 ICT Program Participation Form</h2>
    <?php if ($formMessage): ?>
      <p class="message"><?= htmlspecialchars($formMessage) ?></p>
    <?php endif; ?>
    <form method="POST">
      <label for="fullname">Full Name</label>
      <input type="text" name="fullname" required />

      <label for="email">Email Address</label>
      <input type="email" name="email" required />

      <label for="program">Select Program</label>
      <select name="program" required>
        <option value="">-- Choose a program --</option>
        <option value="Web Design">Web Design</option>
        <option value="Mobile Application">Mobile Application</option>
        <option value="Cybersecurity">Cybersecurity</option>
        <option value="Graphic Design">Graphic Design</option>
        <option value="Computer Maintenance">Computer Maintenance</option>
        <option value="Environmental Literacy">Environmental Literacy</option>
        <option value="Employability Skills">Employability Skills</option>
      </select>

      <label for="interest">What interests you about this program?</label>
      <textarea name="interest" rows="3" required></textarea>

      <label for="expectations">What do you expect to gain?</label>
      <textarea name="expectations" rows="3" required></textarea>

      <label for="challenges">What challenges have you faced?</label>
      <textarea name="challenges" rows="3"></textarea>

      <label for="suggestions">Any suggestions to improve this program?</label>
      <textarea name="suggestions" rows="3"></textarea>

      <button type="submit">Submit Form</button>
    </form>
  </div>
</div>
</body>
</html>
