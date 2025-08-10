<?php
$responseText = "";
$questionText = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $questionText = trim($_POST["question"]);

    if (!empty($questionText)) {
        // Save to database
        $conn = new mysqli("localhost", "root", "", "ict_consultancy_portal");
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO getconsultation (question) VALUES (?)");
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("s", $questionText);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        // Use your actual OpenAI key here:
        $apiKey = "sk-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"; // 🔐 Replace this with your OpenAI key

        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "user", "content" => $questionText]
            ],
            "temperature" => 0.7
        ];

        $ch = curl_init("https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);
        $responseText = $decoded['choices'][0]['message']['content'] ?? "Sorry, no response was generated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ICT Consultancy | Consultation</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      background-color: #000;
    }

    .hero {
      position: relative;
      background: url('https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-attachment: fixed;
    }

    .home-button {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 10;
    }

    .home-button a {
      background: #ffd700;
      color: #000;
      padding: 10px 20px;
      border-radius: 4px;
      font-weight: bold;
      text-decoration: none;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.65);
      padding: 60px 20px;
      width: 100%;
      max-width: 800px;
      margin: auto;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
    }

    h1 {
      font-size: 2.5em;
      color: #00ffff;
      margin-bottom: 20px;
    }

    form {
      margin-top: 20px;
    }

    textarea {
      width: 100%;
      max-width: 700px;
      padding: 15px;
      font-size: 1em;
      border-radius: 10px;
      border: none;
      resize: none;
      margin-bottom: 20px;
    }

    button {
      background-color: #5e17eb;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 6px;
      font-size: 1.1em;
      transition: 0.3s;
      cursor: pointer;
    }

    button:hover {
      background-color: #824fff;
    }

    .response-box {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255,255,255,0.2);
      margin-top: 30px;
      padding: 30px;
      border-radius: 12px;
      backdrop-filter: blur(10px);
      box-shadow: 0 0 15px rgba(0,255,255,0.3);
      color: #fff;
    }

    .response-box h2 {
      color: #00ffff;
      margin-bottom: 10px;
    }

    .response-box p {
      font-size: 1.1em;
      line-height: 1.6;
      white-space: pre-wrap;
    }

    @media screen and (max-width: 600px) {
      .overlay {
        padding: 30px 15px;
      }
      textarea {
        font-size: 0.9em;
      }
    }
  </style>
</head>
<body>

  <div class="hero" id="consultation">
    <div class="home-button">
      <a href="Homepage.php">← Home</a>
    </div>
    <div class="overlay">
      <h1>Get a Free Consultation</h1>
      <form method="POST">
        <textarea name="question" rows="5" placeholder="Ask your question..." required><?= htmlspecialchars($questionText) ?></textarea>
        <br>
        <button type="submit">Get a Response</button>
      </form>

      <?php if (!empty($responseText)): ?>
        <div class="response-box">
          <h2>Your Question</h2>
          <p><?= nl2br(htmlspecialchars($questionText)) ?></p>
          <h2>Answer is right on the way...</h2>
          <p><?= nl2br(htmlspecialchars($responseText)) ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
