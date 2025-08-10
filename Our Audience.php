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
  <title>Our Audience | ICT CONSULTANCY</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1527689368864-3a821dbccc34?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
      background-size: cover;
      color: #ffffff;
    }

    .overlay {
      background-color: rgba(0, 0, 60, 0.75);
      padding: 60px 20px;
      min-height: 100vh;
      position: relative;
    }

    .home-button {
      position: absolute;
      top: 30px;
      left: 30px;
      z-index: 100;
    }

    .home-button a {
      text-decoration: none;
      background-color: #00ffc8;
      color: #000;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .home-button a:hover {
      background-color: #00ccaa;
    }

    h1 {
      text-align: center;
      font-size: 3em;
      color: #00ffc8;
      text-shadow: 2px 2px 6px #000;
      margin-bottom: 40px;
    }

    .section {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 30px;
      margin: 0 auto 50px auto;
      max-width: 850px;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
      animation: fadeIn 2s ease;
    }

    .section h2 {
      font-size: 2em;
      color: #ffd700;
      text-shadow: 1px 1px 3px #000;
      text-align: center;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.3em;
      color: #e0ffe0;
      line-height: 1.7;
      text-shadow: 1px 1px 2px #000;
      text-align: center;
      padding: 0 20px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2em;
      }

      .section h2 {
        font-size: 1.5em;
      }

      p {
        font-size: 1.1em;
      }
    }
  </style>
</head>
<body>

  <div class="overlay">
    <div class="home-button">
      <a href="Homepage.php">← Home</a>
    </div>

    <h1>Our Audience – ICT CONSULTANCY</h1>

    <div class="section">
      <h2>Who We Serve</h2>
      <p>
        ICT CONSULTANCY caters to a wide and dynamic group of <strong>trainees and trainers</strong> looking to develop competitive ICT skills.
        We host programs that support between <strong>600 to 1,000 participants</strong> annually — including students, professionals, and digital freelancers — all eager to enhance their knowledge, capacity, and careers.
      </p>
    </div>
  </div>

  <script>
    // Optional: add navigation highlight or logic to integrate better
    console.log("Our Audience page loaded and linked to Homepage.php");
  </script>

</body>
</html>
