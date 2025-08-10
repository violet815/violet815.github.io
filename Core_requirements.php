<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Core Requirements - ICT Consultancy</title>
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.7);
      min-height: 100vh;
      padding: 60px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
    }

    h1 {
      font-size: 3em;
      color: #00e6b8;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 40px;
    }

    h1 img {
      width: 40px;
      height: 40px;
    }

    .section {
      background: rgba(255, 255, 255, 0.1);
      padding: 25px 30px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      max-width: 900px;
    }

    .section h2 {
      color: #fdd835;
      margin-bottom: 15px;
    }

    .section p {
      font-size: 1.15em;
      color: #e0f7fa;
      line-height: 1.6;
    }

    .home-btn {
      margin-top: 30px;
      background-color: #00d1b2;
      color: #fff;
      padding: 12px 24px;
      font-size: 1.1em;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .home-btn:hover {
      background-color: #00b49c;
    }
  </style>
</head>
<body>
  <div class="overlay">
    <h1><img src="https://img.icons8.com/color/48/maintenance.png" alt="Core Icon"/> Core Requirements</h1>

    <div class="section">
      <h2>Service Offerings & Solutions</h2>
      <p>We deliver customized digital transformation services, including cloud infrastructure setup, e-learning platforms, ICT training, and performance analytics for education institutions.</p>
    </div>

    <div class="section">
      <h2>Security and Data Privacy</h2>
      <p>Security is central to our operations. We use advanced encryption, regular audits, compliance protocols, and secure data handling policies to protect client and student information.</p>
    </div>


    <a href="Homepage.php" class="home-btn">← Back to Homepage</a>

  </div>
</body>
</html>
