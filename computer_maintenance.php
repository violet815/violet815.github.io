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

    pre {
      background-color: #222;
      color: #0f0;
      padding: 10px;
      border-radius: 6px;
      overflow-x: auto;
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
      <iframe src="https://www.youtube.com/embed/AkFi90lZmXA" title="Computer Maintenance - Introduction & Basics" allowfullscreen></iframe>
      <p><a href="https://www.youtube.com/results?search_query=computer+maintenance+basics+for+beginners" target="_blank">🔍 Explore More on YouTube</a></p>
    </div>

    <div class="section">
      <h2>🔧 Practice Platforms & Resources</h2>
      <ul>
        <li><a href="https://www.testout.com" target="_blank">TestOut PC Pro</a> – Virtual labs and certification in PC maintenance.</li>
      </ul>
      <iframe src="https://www.youtube.com/embed/X6Ub4i14HL4" title="Dell XPS 8700 Teardown & Upgrade Guide" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/GCpiA0q2kvo" title="How to Fix Windows Update Stuck at 0%" allowfullscreen></iframe>
    </div>

    <div class="section">
      <h2>📘 Study Notes & Code Snippets</h2>
      <ul>
        <li><strong>🧼 PC Cleaning Steps:</strong>
          <ol>
            <li>Turn off and unplug your PC.</li>
            <li>Open the casing and use compressed air to clean the fans and components.</li>
            <li>Use a soft brush to clean around tight areas.</li>
            <li>Wipe surfaces with an anti-static cloth.</li>
          </ol>
        </li>

        <li><strong>💾 Disk Cleanup in Windows:</strong>
          <pre><code>Start → Search "Disk Cleanup" → Select Drive → OK</code></pre>
        </li>

        <li><strong>🧰 Open Task Manager:</strong>
          <pre><code>Ctrl + Shift + Esc</code></pre>
          <p>Use Task Manager to monitor processes, startup apps, and performance.</p>
        </li>

        <li><strong>📂 Check Disk Health:</strong>
          <pre><code>chkdsk C: /f /r</code></pre>
          <p><small>This checks for file system errors and bad sectors on the drive.</small></p>
        </li>

        <li><strong>🛠️ Use Command Prompt Tools:</strong>
          <ul>
            <li><code>sfc /scannow</code> – Scan and repair system files</li>
            <li><code>ipconfig /all</code> – Show full network configuration</li>
            <li><code>tasklist</code> – List running processes</li>
          </ul>
        </li>

        <li><strong>📡 BIOS Access (Common Keys):</strong>
          <p>Press <code>DEL</code>, <code>F2</code>, or <code>F10</code> during boot to access BIOS/UEFI.</p>
        </li>

        <li><strong>🧪 Common Tools for Maintenance:</strong>
          <ul>
            <li><a href="https://www.ccleaner.com" target="_blank">CCleaner</a> – Removes junk files and optimizes performance.</li>
            <li><a href="https://www.memtest86.com/" target="_blank">MemTest86</a> – Tests RAM for errors.</li>
            <li><a href="https://crystalmark.info/en/software/crystaldiskinfo/" target="_blank">CrystalDiskInfo</a> – Checks hard drive health.</li>
          </ul>
        </li>
      </ul>
    </div>

    <section class="section" style="text-align: center;">
  <h2>📝 Participate in ICT Program</h2>
  <p>Click below to fill out the computer_maintenance participation form.</p>
  <a href="program_form.php?program=Graphic%20Design" style="background: #0984e3; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">Fill the Form</a>
</section>
      </form>
    </div>
  </div>
</body>
</html>
