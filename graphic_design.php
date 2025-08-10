<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) {     
    header("Location: login.php");     
    exit(); 
}

require 'connection.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["reflection"])) {
    $reflection = trim($_POST["reflection"]);
    $user_id = $_SESSION["user_id"];

    if (!empty($reflection)) {
        $stmt = $conn->prepare("INSERT INTO reflections (user_id, reflection) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $reflection);
        if ($stmt->execute()) {
            $message = "✅ Thanks for your feedback!";
        } else {
            $message = "❌ Failed to save reflection.";
        }
        $stmt->close();
    } else {
        $message = "⚠️ Please write something before submitting.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Learn & Practice Graphic Design</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: url('https://images.unsplash.com/photo-1506765515384-028b60a970df?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      color: #2c3e50;
    }

    .overlay {
      background-color: rgba(255, 255, 255, 0.88);
      padding: 60px 20px;
      min-height: 100vh;
    }

    .nav-buttons {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1000;
      display: flex;
      gap: 10px;
    }

    .nav-buttons a {
      background: #0984e3;
      color: #fff;
      padding: 10px 16px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
      transition: background 0.3s;
    }

    .nav-buttons a:hover {
      background: #74b9ff;
    }

    h1, h2, h3 {
      color: #2c3e50;
      text-align: center;
      margin-top: 1.5em;
    }

    .section {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 12px;
      margin: 40px auto;
      max-width: 900px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    iframe {
      width: 100%;
      border: none;
      border-radius: 8px;
      aspect-ratio: 16/9;
      margin-bottom: 10px;
    }

    ul {
      padding-left: 20px;
    }

    ul li {
      margin-bottom: 10px;
    }

    ul li a {
      color: #0984e3;
      text-decoration: none;
    }

    ul li a:hover {
      text-decoration: underline;
    }

    textarea {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1em;
      resize: vertical;
      background: #f9f9f9;
      color: #000;
    }

    button {
      padding: 10px 20px;
      background-color: #0984e3;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1em;
      margin-top: 12px;
    }

    button:hover {
      background-color: #74b9ff;
    }

    .message {
      color: green;
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }

    @media (max-width: 768px) {
      body { padding: 10px; }
      h1 { font-size: 1.8em; }
      .nav-buttons {
        flex-direction: column;
        top: 10px;
        left: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <div class="nav-buttons">
      <a href="Homepage.php">← Home</a>
      <a href="programs.php">← Back to Programs</a>
    </div>

    <h1>🎨 Learn & Practice Graphic Design</h1>

    <section class="section">
      <h2>📺 Featured YouTube Tutorials</h2>

      <h3>1. Graphic Design Basics – Envato Tuts+</h3>
      <iframe src="https://www.youtube.com/embed/GQS7wPujL2k" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/watch?v=GQS7wPujL2k" target="_blank">Watch on YouTube</a></p>

      <h3>2. Graphic Design Essentials – Flux Academy</h3>
      <iframe src="https://www.youtube.com/embed/SnxFkHqN1RA" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/watch?v=SnxFkHqN1RA" target="_blank">Watch on YouTube</a></p>

      <h3>3. Graphic Design Workflows – Satori Graphics</h3>
      <iframe src="https://www.youtube.com/embed/4NGywqnnl5Y" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/watch?v=4NGywqnnl5Y" target="_blank">Watch on YouTube</a></p>
    </section>

    <section class="section">
      <h2>🛠️ Guided Design Tasks</h2>
      <ol>
        <li>Use the <strong>Quick Selection Tool</strong> in Photopea to remove backgrounds.</li>
        <li>Create a layered design with text and shapes.</li>
        <li>Experiment with <strong>layer styles</strong> and <strong>blending modes</strong>.</li>
        <li>Design a flyer, business card, or social media graphic from scratch.</li>
      </ol>
    </section>

    <section class="section">
      <h2>🧑‍💻 Practice Platform – Photopea</h2>
      <iframe src="https://www.photopea.com/" height="600" title="Photopea Editor"></iframe>
    </section>

    <section class="section">
      <h2>🌐 Bonus Learning Platforms</h2>
      <ul>
        <li><a href="https://www.coursera.org/specializations/graphic-design" target="_blank">Coursera – CalArts Graphic Design Specialization</a></li>
        <li><a href="https://www.udemy.com/course/graphic-design-masterclass-everything-you-need-to-know/" target="_blank">Udemy – Graphic Design Masterclass</a></li>
        <li><a href="https://www.skillshare.com/browse/graphic-design" target="_blank">Skillshare – Creative Design Projects</a></li>
        <li><a href="https://www.canva.com/designschool/" target="_blank">Canva Design School</a></li>
        <li><a href="https://www.linkedin.com/learning/paths/become-a-graphic-designer" target="_blank">LinkedIn Learning – Designer Pathway</a></li>
      </ul>
    </section>

  <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the Graphic Design participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>

      </form>
    </section>
  </div>
</body>
</html>
