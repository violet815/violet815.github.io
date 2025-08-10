<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'web.php'; // DB connection

$feedbackMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reflection'])) {
    $user_id = $_SESSION['user_id'];
    $reflection = trim($_POST['reflection']);

    if (!empty($reflection)) {
        $stmt = $conn->prepare("INSERT INTO maintenance_reflections (user_id, reflection) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("is", $user_id, $reflection);
            if ($stmt->execute()) {
                $feedbackMessage = "✅ Thanks for your reflection!";
            } else {
                $feedbackMessage = "❌ Failed to submit.";
            }
        } else {
            $feedbackMessage = "❌ Database error.";
        }
    } else {
        $feedbackMessage = "⚠️ Please write something before submitting.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>🛠️ Computer Maintenance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1573497491208-6b1acb260507') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 40px 20px;
      min-height: 100vh;
    }

    h1, h2 {
      text-align: center;
      color: #00ffcc;
    }

    .section {
      background-color: rgba(255, 255, 255, 0.08);
      border-radius: 12px;
      padding: 30px;
      margin: 30px auto;
      max-width: 1000px;
      box-shadow: 0 0 20px rgba(0,0,0,0.6);
    }

    iframe {
      width: 100%;
      height: 480px;
      border-radius: 10px;
      margin-bottom: 20px;
      border: none;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 12px;
    }

    textarea {
      width: 100%;
      height: 120px;
      border-radius: 10px;
      padding: 12px;
      font-size: 1rem;
      margin-top: 10px;
    }

    button {
      background: #00ffcc;
      color: black;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      margin-top: 10px;
      cursor: pointer;
    }

    .message {
      text-align: center;
      margin-top: 10px;
      color: #80ffea;
      font-weight: bold;
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .back-button a {
      background: #ffd700;
      color: black;
      padding: 10px 15px;
      border-radius: 5px;
      font-weight: bold;
      text-decoration: none;
    }

    @media (max-width: 768px) {
      iframe {
        height: 300px;
      }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <div class="back-button">
      <a href="programs.php">← Back to Programs</a>
    </div>

    <h1>🛠️ Computer Maintenance</h1>

    <div class="section">
      <h2>📺 Learning Videos</h2>

      <iframe src="https://www.youtube.com/embed/iHCyQTnTvmc" title="PC Maintenance & Troubleshooting - IT Basics" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/MdZ_tN2Xx9Q" title="How to Assemble a Computer Step-by-Step" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/qD-ck69JvrU" title="Basic Computer Hardware Full Course" allowfullscreen></iframe>

      <p><a href="https://www.youtube.com/results?search_query=computer+maintenance+course" target="_blank">🔍 Explore More on YouTube</a></p>
    </div>

    <div class="section">
      <h2>🔧 Practice Platforms & Resources</h2>
      <ul>
        <li><a href="https://www.testout.com" target="_blank">TestOut PC Pro</a> – Virtual labs and certification in PC maintenance.</li>
        <li><a href="https://www.howtogeek.com/" target="_blank">HowToGeek</a> – Simple guides for common troubleshooting.</li>
        <li><a href="https://www.pcworld.com/" target="_blank">PCWorld</a> – Hardware reviews and repair tips.</li>
      </ul>
    </div>

    <div class="section">
      <h2>💬 What Did You Learn?</h2>
      <?php if ($feedbackMessage): ?>
        <p class="message"><?= htmlspecialchars($feedbackMessage) ?></p>
      <?php endif; ?>
      <form method="POST">
        <textarea name="reflection" placeholder="Write what you learned today..." required></textarea><br>
        <button type="submit">Submit Reflection</button>
      </form>
    </div>
  </div>
</body>
</html>
