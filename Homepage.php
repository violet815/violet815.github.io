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
  <title>ICT Consultancy - Empowering Digital Education</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
    }

    html, body {
      height: 100%;
      background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      flex-direction: column;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .menu-toggle {
      position: fixed;
      top: 20px;
      left: 20px;
      width: 30px;
      height: 25px;
      cursor: pointer;
      z-index: 1001;
    }

    .menu-toggle div {
      background: #FFD700;
      height: 4px;
      margin: 5px 0;
      border-radius: 2px;
    }

    aside {
      width: 250px;
      background-color: #202020;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      padding: 60px 15px 20px;
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      overflow-y: auto;
    }

    aside.active {
      transform: translateX(0);
    }

    .logo {
      text-align: center;
      font-size: 1.8rem;
      font-weight: bold;
      color: #92d050;
      margin-bottom: 30px;
    }

    .sidebar-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 8px;
      background-color: #2e2e2e;
      transition: background 0.3s ease;
    }

    .sidebar-item:hover {
      background-color: #444;
    }

    .sidebar-item img {
      width: 26px;
      height: 26px;
    }

    main {
      margin-left: 0;
      padding: 40px 20px;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: margin-left 0.3s ease;
    }

    aside.active ~ main {
      margin-left: 250px;
    }

    .hero {
      background-color: rgba(0, 0, 0, 0.5);
      padding: 50px 30px;
      border-radius: 8px;
      text-align: center;
    }

    .hero h1 {
      font-size: 2.8rem;
      color: #FFD700;
      margin-bottom: 15px;
    }

    .hero p {
      font-size: 1.1rem;
      color: #d0f0c0;
      max-width: 700px;
      margin: 0 auto;
    }

    .stats {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 25px;
      flex-wrap: wrap;
    }

    .stat {
      background: rgba(0, 0, 0, 0.6);
      padding: 10px 16px;
      border-radius: 6px;
      font-size: 0.95rem;
    }

    .who-we-are {
      background-color: rgba(255,255,255,0.95);
      padding: 25px 20px;
      border-radius: 8px;
      color: #111;
      text-align: center;
      margin-top: 40px;
    }

    .who-we-are h2 {
      font-size: 1.7rem;
      color: #00509d;
      margin-bottom: 10px;
    }

    .who-we-are p {
      font-size: 1rem;
      max-width: 700px;
      margin: auto;
      line-height: 1.6;
    }

    footer {
      background: linear-gradient(to right, #0a0f24, #1a1f3c);
      color: #d1e7ff;
      padding: 15px 20px;
      text-align: center;
      font-size: 0.85em;
      box-shadow: 0 -1px 6px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }
      .hero p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

<!-- Hamburger menu -->
<div class="menu-toggle" onclick="document.querySelector('aside').classList.toggle('active')">
  <div></div><div></div><div></div>
</div>

<!-- Sidebar -->
<aside>
  <div class="logo">ICT</div>
  <a class="sidebar-item" href="aboutus.html"><img src="https://img.icons8.com/color/48/about.png"/>About Us</a>
  <a class="sidebar-item" href="admissions.php"><img src="https://img.icons8.com/color/48/student-male.png"/>Admissions</a>
  <a class="sidebar-item" href="goals.html"><img src="https://img.icons8.com/color/48/goal.png"/>Goals</a>
  <a class="sidebar-item" href="Our Audience.php"><img src="https://img.icons8.com/color/48/conference-call.png"/>Our Audience</a>
  <a class="sidebar-item" href="StudentResources.html"><img src="https://img.icons8.com/color/48/books.png"/>Resources</a>
  <a class="sidebar-item" href="contactus.html"><img src="https://img.icons8.com/color/48/new-post.png"/>Contact</a>
  <a class="sidebar-item" href="report_users.php"><img src="https://img.icons8.com/color/48/new-post.png"/>report</a>

  <!-- ✅ Core Requirements link -->
  <a class="sidebar-item" href="core_requirements.php">

  <!-- ✅ Core Requirements link -->
  <a class="sidebar-item" href="core_requirements.php">
  <img src="https://img.icons8.com/color/48/maintenance.png"/>Core Requirements
</a>

  <a class="sidebar-item" href="newsandevents.html"><img src="https://img.icons8.com/color/48/news.png"/>News</a>
  <a class="sidebar-item" href="problemsolved.html"><img src="https://img.icons8.com/color/48/idea.png"/>Problem Solved</a>
  <a class="sidebar-item" href="program_access_portal.php"><img src="https://img.icons8.com/color/48/online.png"/>Programs</a>
  <a class="sidebar-item" href="purpose.html"><img src="https://img.icons8.com/color/48/purpose.png"/>Purpose</a>
  <a class="sidebar-item" href="sitemap.html"><img src="https://img.icons8.com/color/48/sitemap.png"/>Sitemap</a>
  <a class="sidebar-item" href="signup.php"><img src="https://img.icons8.com/color/48/add-user-group-man-man.png"/>Signup</a>
  <a class="sidebar-item" href="login.php"><img src="https://img.icons8.com/color/48/enter-2.png"/>Login</a>
  <a class="sidebar-item" href="logout.php"><img src="https://img.icons8.com/color/48/logout-rounded.png"/>Logout</a>
</aside>

<main>
  <section class="hero">
    <h1>Welcome to ICT Consultancy</h1>
    <p>We use ICT to transform education in Kenya with tools, training, and engagement models.</p>
    <div class="stats">
      <div class="stat">📊 30+ Institutions</div>
      <div class="stat">🎓 2,000+ Students</div>
      <div class="stat">📈 5+ Metrics</div>
    </div>
  </section>

  <section class="who-we-are">
    <h2>Who We Are</h2>
    <p>ICT Consultancy is committed to improving digital education access and engagement. We empower learners through modern ICT tools and skills for future success.</p>
  </section>
</main>

<footer>
  &copy; 2025 Engage Kenya. All rights reserved.
</footer>

</body>
</html>
