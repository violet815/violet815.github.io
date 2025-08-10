<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'employskills.php';//Db connection

$feedbackMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reflection'])) {
    $user_id = $_SESSION['user_id'];
    $reflection = trim($_POST['reflection']);
    if (!empty($reflection)) {
        $stmt = $conn->prepare("INSERT INTO employability_reflections (user_id, reflection) VALUES (?, ?)");
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
  <title>Employability Skills</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('images/employability_bg.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      padding: 30px;
    }
    h1 {
      color: #ffe600;
    }
    .section {
      background-color: rgba(0,0,0,0.7);
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
      background-color: #ffe600;
      color: #000;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }
    .message {
      color: #00ff99;
    }
  </style>
</head>
<body>
    

  <div style="margin-bottom: 20px;">
    <a href="programs.php" style="text-decoration: none;">
      <button style="padding: 10px 20px; background-color: #ffe600; color: #000; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
        ← Back to programs
      </button>
    </a>
  </div>

  <div class="section">
    <h1>Employability Skills: Build Your Future</h1>
    <p>Sharpen your communication, leadership, and work-readiness techniques with the videos and resources below.</p>
  </div>


  <div class="section">
    <h1>Employability Skills: Build Your Future</h1>
    <p>Sharpen your communication, leadership, and work-readiness techniques with the videos and resources below.</p>
  </div>

  <div class="section">
    <h2>💬 Communication Skills</h2>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/6pYSbdGiDYw" title="Effective Communication Skills by Alex Lyon" frameborder="0" allowfullscreen></iframe>

  </div>

  <div class="section">
    <h2>👩‍💼 Leadership Skills</h2>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/DyC57XSnlAo" title="Employability Skills: All Eight Skills" frameborder="0" allowfullscreen></iframe>

  </div>

  <div class="section">
    <h2>🧠 Work Readiness & Professionalism</h2>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/qBvKxm0P1po" title="Developing Workplace Readiness Skills" frameborder="0" allowfullscreen></iframe>

  </div>

  <div class="section">
    <h2>📚 Learning Platforms</h2>
    <ul>
      <li><a href="https://alison.com/tag/employability-skills" target="_blank" style="color:#ffe600;">Alison – Free Employability Courses</a></li>
      <li><a href="https://www.futurelearn.com/courses/employability-skills" target="_blank" style="color:#ffe600;">FutureLearn – Employability Skills</a></li>
      <li><a href="https://www.edx.org/learn/employability" target="_blank" style="color:#ffe600;">edX – Employability Learning</a></li>
    </ul>
  </div>

   <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the Employability_skills participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>

</body>
</html>
