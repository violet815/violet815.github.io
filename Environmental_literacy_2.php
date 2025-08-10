<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'environment.php'; // DB connection using environmental_literacy

$feedbackMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reflection'])) {
    $user_id = $_SESSION['user_id'];
    $reflection = trim($_POST['reflection']);
    if (!empty($reflection)) {
        $stmt = $conn->prepare("INSERT INTO environmental_reflections (user_id, reflection) VALUES (?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("is", $user_id, $reflection);
        if ($stmt->execute()) {
            $feedbackMessage = "Reflection submitted successfully!";
        } else {
            $feedbackMessage = "Error: " . $stmt->error;
        }
    } else {
        $feedbackMessage = "Please enter your reflection.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Environmental Literacy</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1545239351-1141bd82e8a6') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      padding: 30px;
    }
    h1 {
      color: #00ff99;
    }
    .section {
      background-color: rgba(0,0,0,0.75);
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 20px;
    }
    iframe {
      width: 100%;
      height: 300px;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    textarea {
      width: 100%;
      height: 120px;
      border-radius: 10px;
      padding: 10px;
    }
    input[type="submit"] {
      padding: 10px 25px;
      background-color: #00ff99;
      color: #000;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }
    .message {
      color: #00ff99;
    }
    .back-button {
      margin-bottom: 20px;
    }
    .back-button a {
      background-color: #00ff99;
      padding: 10px 20px;
      color: #000;
      text-decoration: none;
      border-radius: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="back-button">
  <a href="programs.php">← Back to Programs</a>
</div>

<div class="section">
  <h1>Environmental Literacy: A Greener Future</h1>
  <p>Understand climate, sustainability, and green practices for a brighter future.</p>
</div>

<div class="section">
  <h2>Environmental Literacy – Introduction</h2>
  <h3>1. Climate Literacy Principles & Guidelines</h3>
  <iframe src="https://www.youtube.com/embed/r_tDZSN8l2o" title="Climate Literacy Principles & Guidelines" frameborder="0" allowfullscreen></iframe>

  <h3>2. How to Talk About the Environment in English</h3>
  <iframe src="https://www.youtube.com/embed/zKAYAnLsoUk" title="How to Talk About the Environment in English - Spoken English Lesson" frameborder="0" allowfullscreen></iframe>

  <h3>3. Environmental Literacy – Introduction</h3>
  <iframe src="https://www.youtube.com/embed/I5FttqD5F0Q" title="Environmental Literacy – Introduction" frameborder="0" allowfullscreen></iframe>
</div>

<div class="section">
  <h2>♻️ Green Practices & Responsibility</h2>
  <iframe src="https://www.youtube.com/embed/zCRKvDyyHmI" title="How to be More Sustainable" frameborder="0" allowfullscreen></iframe>
</div>

<div class="section">
  <h2>📚 Learning Platforms</h2>
  <ul>
    <li><a href="https://www.edx.org/learn/environmental-science" target="_blank" style="color:#00ff99;">edX – Environmental Science</a></li>
    <li><a href="https://www.coursera.org/browse/physical-science-and-engineering/environmental-science" target="_blank" style="color:#00ff99;">Coursera – Environmental Literacy</a></li>
    <li><a href="https://sustainabledevelopment.un.org/" target="_blank" style="color:#00ff99;">UN Sustainable Development Goals</a></li>
  </ul>
</div>

 <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the Environmental_literacy participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>

</body>
</html>
