<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'web.php'; // Connect to web_learning_db

$feedbackMessage = "";

// Handle name-based reflection (no foreign key)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name_reflect'])) {
    $name = trim($_POST['name']);
    $reflection = trim($_POST['name_reflection']);

    if (!empty($name) && !empty($reflection)) {
        $stmt = $conn->prepare("INSERT INTO cyber_learning_reflections (name, reflection) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $name, $reflection);
            if ($stmt->execute()) {
                $feedbackMessage = "✅ Reflection submitted successfully!";
            } else {
                $feedbackMessage = "❌ Failed to submit: " . $stmt->error;
            }
        } else {
            $feedbackMessage = "❌ Statement error: " . $conn->error;
        }
    } else {
        $feedbackMessage = "⚠️ Please fill in both fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>🔐 Cyber Security Mastery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: url('https://images.unsplash.com/photo-1581092334495-3e7b62f86c89') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.85);
      min-height: 100vh;
      padding: 40px 20px;
    }

    h1, h2 {
      text-align: center;
      color: #00ffcc;
      margin-bottom: 20px;
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
      border: none;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 12px;
    }

    textarea, input {
      width: 100%;
      border-radius: 10px;
      padding: 12px;
      font-size: 1rem;
      margin-top: 10px;
      border: none;
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

    <h1>🔐 Cyber Security Mastery</h1>

    <div class="section">
      <h2>🎥 Video Tutorials</h2>
      <iframe src="https://www.youtube.com/embed/hXSFdwIOfnE" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/inWWhr5tnEA" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/results?search_query=cyber+security+training+for+beginners+english" target="_blank">📺 Browse More Tutorials</a></p>
    </div>

    <div class="section">
      <h2>🛠️ Practice Platforms</h2>
      <ul>
        <li><a href="https://tryhackme.com" target="_blank">TryHackMe</a></li>
        <li><a href="https://www.hackthebox.com/" target="_blank">Hack The Box</a></li>
        <li><a href="https://owasp.org/" target="_blank">OWASP</a></li>
        <li><a href="https://cybersecurityguide.org/" target="_blank">Cybersecurity Career Guide</a></li>
      </ul>
    </div>

     </section>

  <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the cyber_security  participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>
n</button>
      </form>
    </div>
  </div>
</body>
</html>
