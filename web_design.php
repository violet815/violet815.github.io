<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'web.php'; // ✅ Connects to maintenance_portal

$feedbackMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reflection'])) {
    $user_id = $_SESSION['user_id'];
    $reflection = trim($_POST['reflection']);

    if (!empty($reflection)) {
        // ✅ Attempt to auto-create user if not found (fix for FK constraint)
        $check = $conn->prepare("SELECT user_id FROM user_reports WHERE user_id = ?");
        $check->bind_param("i", $user_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            // Auto-register user with placeholder details (adjust if needed)
            $insertUser = $conn->prepare("INSERT INTO user_reports (user_id, firstname, lastname, email, gender, password) VALUES (?, 'Auto', 'User', 'auto_user@example.com', 'N/A', '')");
            $insertUser->bind_param("i", $user_id);
            $insertUser->execute();
            $insertUser->close();
        }

        $check->close();

        // Now insert the reflection
        $stmt = $conn->prepare("INSERT INTO web_design_reflections (user_id, reflection) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("is", $user_id, $reflection);
            if ($stmt->execute()) {
                $feedbackMessage = "✅ Thanks for your reflection!";
            } else {
                $feedbackMessage = "❌ Could not save your feedback. Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $feedbackMessage = "❌ SQL Error: " . $conn->error;
        }
    } else {
        $feedbackMessage = "⚠️ Please write something before submitting.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🌐 Web Design Mastery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: url('https://images.unsplash.com/photo-1505685296765-3a2736de412f') no-repeat center center fixed;
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
      color: #00ffe1;
      margin-bottom: 20px;
    }

    .section {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 30px;
      margin: 30px auto;
      max-width: 1000px;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
    }

    iframe {
      width: 100%;
      height: 500px;
      border-radius: 10px;
      border: none;
      margin-bottom: 15px;
    }

    textarea {
      width: 100%;
      height: 120px;
      border-radius: 10px;
      padding: 12px;
      font-size: 1rem;
      resize: vertical;
      margin-top: 10px;
    }

    button {
      background: #00ffe1;
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
      font-weight: bold;
      margin-top: 10px;
      color: #55efc4;
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
    <div class="back-button">
      <a href="programs.php">← Back to Programs</a>
    </div>

    <h1>🌐 Web Design Mastery</h1>

    <div class="section">
      <h2>🎥 Video Tutorials</h2>
      <iframe src="https://www.youtube.com/embed/pQN-pnXPaVg" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/UB1O30fR-EE" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/results?search_query=html+css+javascript+tutorial" target="_blank">📺 More on YouTube</a></p>
    </div>

     </section>

  <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the web_design  participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>

      </form>
    </div>
  </div>
</body>
</html>
