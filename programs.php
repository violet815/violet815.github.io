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
  <title>Our Programs | ICT Consultancy</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1535223289827-42f1e9919769') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.75);
      padding: 80px 20px 40px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      position: relative;
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

    h1 {
      font-size: 3.5em;
      margin-bottom: 10px;
      animation: fadeIn 2s ease-in-out;
      color: #ffd700;
      text-shadow: 2px 2px #222;
    }

    h3 {
      font-size: 1.5em;
      margin-bottom: 40px;
      color: #f0e68c;
      animation: fadeIn 2.5s ease-in-out;
    }

    .course-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 30px;
      width: 90%;
      max-width: 1100px;
    }

    .course-box {
      background-color: rgba(255, 255, 255, 0.08);
      padding: 30px 20px;
      border-radius: 12px;
      border: 1px solid #ffd700;
      backdrop-filter: blur(3px);
      animation: slideUp 1s ease forwards;
      opacity: 0;
      color: white;
      transition: transform 0.3s ease;
    }

    .course-box:hover {
      transform: translateY(-5px);
    }

    .course-box h2 {
      font-size: 1.4em;
      margin-bottom: 10px;
    }

    .course-box p {
      font-size: 1em;
      color: #dcdcdc;
    }

    a.course-link {
      text-decoration: none;
    }

    .course-box:nth-child(1) { animation-delay: 0.5s; }
    .course-box:nth-child(2) { animation-delay: 0.8s; }
    .course-box:nth-child(3) { animation-delay: 1.1s; }
    .course-box:nth-child(4) { animation-delay: 1.4s; }
    .course-box:nth-child(5) { animation-delay: 1.7s; }
    .course-box:nth-child(6) { animation-delay: 2.0s; }
    .course-box:nth-child(7) { animation-delay: 2.3s; }

    @keyframes slideUp {
      from { transform: translateY(40px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @media(max-width: 600px) {
      h1 { font-size: 2.5em; }
      h3 { font-size: 1.2em; }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <div class="home-button">
      <a href="Homepage.php">← Home</a>
    </div>

    <h1>Explore Our Programs</h1>
    <h3>Empowering learners with skills that matter most today</h3>

    <div class="course-grid">

      <!-- Graphic Design -->
      <a href="graphic_design.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/color/48/adobe-photoshop.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Graphic Design</h2>
          <p>Master creativity through design tools for branding, advertising, and social media.</p>
        </div>
      </a>

      <!-- Mobile Application -->
      <a href="mobile_app.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/android-os.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Mobile Application</h2>
          <p>Learn to build intuitive apps using Android and cross-platform technologies.</p>
        </div>
      </a>

      <!-- Web Design -->
      <a href="web_design.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/code.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Web Design</h2>
          <p>Explore HTML, CSS, and JavaScript to craft responsive, modern websites.</p>
        </div>
      </a>

      <!-- Cyber Security -->
      <a href="cyber_security.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/lock-2.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Cyber Security</h2>
          <p>Get trained on how to safeguard data, systems, and your digital footprint.</p>
        </div>
      </a>

      <!-- Computer Maintenance -->
      <a href="computer_maintenance.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/computer.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Computer Maintenance</h2>
          <p>Diagnose, troubleshoot, and upgrade hardware and software components.</p>
        </div>
      </a>

      <!-- Employability Skills -->
      <a href="Employability_skills.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/business-group.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Employability Skills</h2>
          <p>Sharpen your communication, leadership, and work-readiness techniques.</p>
        </div>
      </a>

      <!-- Environmental Literacy -->
      <a href="Environmental_literacy.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/planet-earth.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Environmental Literacy</h2>
          <p>Understand climate, sustainability, and green practices for a brighter future.</p>
        </div>
      </a>

    

      <!-- Program Feedback Form -->
      <a href="program_form.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/edit-property.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Program Feedback Form</h2>
          <p>Submit your interests, expectations, and suggestions for any program.</p>
        </div>
      </a>

      <!-- 🔄 Program Forms Report -->
      <a href="program_forms_report.php" class="course-link">
        <div class="course-box">
          <h2><img src="https://img.icons8.com/fluency/48/report-card.png" style="width:26px; vertical-align:middle; margin-right:10px;"/>Form Submissions Report</h2>
          <p>View all submitted feedback from users across programs.</p>
        </div>
      </a>

    </div>
  </div>
</body>
</html>
