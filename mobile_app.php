<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db_connect.php'; // ✅ Updated filename

$feedbackMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reflection'])) {
    $user_id = $_SESSION['user_id'];
    $reflection = trim($_POST['reflection']);

    if (!empty($reflection)) {
        $stmt = $conn->prepare("INSERT INTO mobile_reflections (user_id, reflection) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $reflection);
        if ($stmt->execute()) {
            $feedbackMessage = "✅ Thanks for your feedback!";
        } else {
            $feedbackMessage = "❌ Error saving feedback.";
        }
    } else {
        $feedbackMessage = "⚠️ Please enter something before submitting.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>📱 Mobile App Mastery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1535223289827-42f1e9919769') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      height: 100vh;
      overflow-y: auto;
    }

    .overlay {
      background-color: rgba(0, 0, 50, 0.85);
      padding: 40px 20px;
      min-height: 100vh;
      width: 100%;
    }

    h1, h2 {
      text-align: center;
      color: #00cec9;
      margin-bottom: 20px;
    }

    .section {
      background: rgba(255, 255, 255, 0.08);
      margin: 30px auto;
      padding: 30px;
      border-radius: 12px;
      max-width: 1000px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
    }

    iframe {
      width: 100%;
      height: 520px;
      border-radius: 10px;
      border: none;
      margin-bottom: 15px;
    }

    a {
      color: #81ecec;
      font-weight: bold;
    }

    textarea {
      width: 100%;
      height: 120px;
      border-radius: 10px;
      padding: 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      resize: vertical;
      margin-top: 10px;
    }

    button {
      background: #00cec9;
      color: #000;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      margin-top: 10px;
      cursor: pointer;
    }

    .message {
      text-align: center;
      margin-top: 10px;
      color: #55efc4;
      font-weight: bold;
    }

    ul {
      padding-left: 20px;
    }

    ul li {
      margin-bottom: 10px;
      line-height: 1.6;
    }

    .home-button {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 10;
    }
    .home-button a {
      display: inline-block;
      background-color: #ffd700;
      color: #000;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .home-button a:hover {
      background-color: #f0c400;
    }

    @media (max-width: 768px) {
      iframe {
        height: 300px;
      }
    }
  </style>
</head>
<body>
  <!-- ✅ Back to Programs Button -->
  <div class="home-button">
    <a href="programs.php">← Back to Programs</a>
  </div>

  <div class="overlay">
    <h1>📱 Mobile App Mastery</h1>

    <div class="section">
      <h2>🎥 YouTube Tutorials</h2>
      <iframe src="https://www.youtube.com/embed/fis26HvvDII" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/mXjZQX3UzOs" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/results?search_query=android+development+tutorial" target="_blank">📺 See More Tutorials</a></p>
    </div>

    <div class="section">
      <h2>🛠️ Practice & Learn Mobile Development</h2>
      <ul>
        <li><strong><a href="https://snack.expo.dev" target="_blank">Expo Snack (Recommended)</a></strong> – Write and run React Native code in the browser instantly.</li>
        <li><strong><a href="https://replit.com" target="_blank">Replit</a></strong> – Practice Dart, Kotlin, JavaScript online.</li>
        <li><strong><a href="https://appinventor.mit.edu/" target="_blank">MIT App Inventor</a></strong> – Drag-and-drop Android builder for beginners.</li>
        <li><strong><a href="https://developer.android.com/studio" target="_blank">Android Studio</a></strong> – For advanced offline development.</li>
      </ul>

      <iframe src="https://snack.expo.dev/embed" title="Practice React Native Live on Snack"></iframe>
    </div>

     </section>

  <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the mobile_app participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>

      </form>
    </div>
  </div>
</body>
</html>
