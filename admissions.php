
<?php
session_start();

// Handle login attempt
$loginError = '';
if (isset($_POST['admin_username'], $_POST['admin_password'])) {
    $u = $_POST['admin_username'];
    $p = $_POST['admin_password'];
    if ($u === 'admin' && $p === 'admin@123') {
        $_SESSION['is_admin'] = true;
    } else {
        $loginError = 'Invalid credentials';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

// Fetch contact submissions... (your existing DB code follows)
?>
<?php
// Fetch Contact Submissions for the report section
$reportContent = "";

$conn = new mysqli("localhost", "root", "", "ict_consultancy_portal");
if ($conn->connect_error) {
    $reportContent = "<p style='color:red;'>❌ Database connection failed.</p>";
} else {
    $sql = "SELECT fullname, programs, message, created_at FROM contact_submissions ORDER BY created_at DESC";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $reportContent = "<table><tr><th>Full Name</th><th>Program</th><th>Message</th><th>Date Submitted</th></tr>";
        while ($r = $res->fetch_assoc()) {
            $reportContent .= "<tr>";
            $reportContent .= "<td>" . htmlspecialchars($r['fullname']) . "</td>";
            $reportContent .= "<td>" . htmlspecialchars($r['programs']) . "</td>";
            $reportContent .= "<td>" . nl2br(htmlspecialchars($r['message'])) . "</td>";
            $reportContent .= "<td>" . htmlspecialchars($r['created_at']) . "</td>";
            $reportContent .= "</tr>";
        }
        $reportContent .= "</table>";
    } else {
        $reportContent = "<p>📭 No fee reports submitted yet.</p>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admissions | ICT Consultancy</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1553877522-43269d4ea984?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
      background-size: cover;
      color: #ffffff;
      text-align: center;
    }
    .overlay {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 60px 20px;
      min-height: 100vh;
    }
    .home-button {
      position: absolute;
      top: 30px;
      left: 30px;
      z-index: 10;
    }
    .home-button a,
    .button-link {
      text-decoration: none;
      background-color: #00ffd9;
      color: #000;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .home-button a:hover,
    .button-link:hover {
      background-color: #00ccaa;
    }
    h1 {
      font-size: 3.2em;
      margin-bottom: 30px;
      color: #00ffd9;
      text-shadow: 2px 2px 5px #000;
      animation: fadeIn 1.8s ease-in-out;
    }
    .section {
      margin-top: 40px;
      padding: 30px;
      background-color: rgba(0, 0, 0, 0.55);
      border-radius: 12px;
      max-width: 850px;
      margin-left: auto;
      margin-right: auto;
      animation: fadeIn 2.5s ease;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
    }
    .section h2 {
      font-size: 2em;
      color: #ffdb4d;
      text-shadow: 1px 1px 3px #000;
      margin-bottom: 15px;
      text-decoration: underline;
    }
    ul {
      list-style-type: disc;
      text-align: left;
      max-width: 600px;
      margin: 0 auto;
      padding-left: 25px;
    }
    li {
      font-size: 1.3em;
      color: #e0ffe0;
      margin: 12px 0;
      text-shadow: 1px 1px 2px #000;
    }
    .button-link {
      display: inline-block;
      padding: 14px 28px;
      background-color: #ffaa00;
      color: #000;
      font-size: 1.2em;
      font-weight: bold;
      border-radius: 8px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }
    .hidden-section {
      display: none;
      text-align: left;
      padding: 20px;
      background-color: rgba(255,255,255,0.1);
      border-radius: 10px;
      margin-top: 20px;
    }
    table {
      width: 100%;
      color: #fff;
      margin-top: 20px;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #444;
    }
    .btn {
      margin-top: 20px;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      background-color: #28a745;
      color: white;
      transition: background-color 0.3s;
    }
    .btn:hover {
      background-color: #218838;
    }
    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 8px;
      border-radius: 6px;
      border: none;
      font-size: 1em;
    }
    .contact-form label {
      margin-top: 12px;
      display: block;
      font-weight: bold;
    }
    .payment-info {
      font-size: 1em;
      margin-top: 15px;
      background: rgba(0,0,0,0.2);
      padding: 15px;
      border-radius: 10px;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @media(max-width: 600px) {
      .home-button { top: 15px; left: 15px; }
      h1 { font-size: 2.3em; }
      .section h2 { font-size: 1.6em; }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <div class="home-button"><a href="homepage.php">← Home</a></div>
    <h1>ADMISSIONS</h1>

    <!-- Requirements -->
    <div class="section">
      <h2>Requirements</h2>
      <ul><li>Laptop</li><li>Smartphone</li><li>Optic Devices</li></ul>
      <a href="purchase_requirements.php" class="button-link">Buy Requirements</a>
    </div>

    <!-- Application Process -->
    <div class="section">
      <h2>Application Process</h2>
      <ul>
        <li>Fill out the <strong>Online Application Form</strong>.</li>
        <li>Upload scanned copies of your National ID or Birth Certificate.</li>
        <li>Attach copies of academic credentials (KCSE, Diploma etc.).</li>
        <li>Submit and wait for an email response within 5 working days.</li>
      </ul>
      <a href="application_form.php" class="button-link">Apply Now</a>
    </div>

    <!-- Fees & Finance -->
    <div class="section">
      <h2>Fees & Finance</h2>
      <ul>
        <li><strong>Registration Fee:</strong> KSH 1,000 (one-time)</li>
        <li><strong>Tuition Fee:</strong> KSH 10,000 per month</li>
        <li><strong>Payment via M-PESA:</strong> Paybill 0724255124, Acc: Your Name/ID</li>
        <li>Flexible Installments allowed</li>
        <li>Confirm with finance office before deadline</li>
      </ul>

      <a href="#" onclick="toggleSection('structure')" class="button-link">📥 View Fee Structure</a>
      <a href="#" onclick="toggleSection('report')" class="button-link" style="background-color:#00ff99">📊 View Fee Reports (Admin)</a>

      <!-- Fee Structure -->
      <div id="structure" class="hidden-section">
        <h3>📥 Fee Structure</h3>
        <table>
          <tr><th>Program Name</th><th>Duration</th><th>Fee (KES)</th></tr>
          <tr><td>Graphic Design</td><td>3 Months</td><td>30,000</td></tr>
          <tr><td>Mobile Application</td><td>4 Months</td><td>40,000</td></tr>
          <tr><td>Web Design</td><td>3 Months</td><td>35,000</td></tr>
          <tr><td>Cyber Security</td><td>6 Months</td><td>60,000</td></tr>
          <tr><td>Computer Maintenance</td><td>2 Months</td><td>20,000</td></tr>
          <tr><td>Employability Skills</td><td>1 Month</td><td>10,000</td></tr>
        </table>
        <button class="btn" onclick="showAllPayment()">🎓 Purchase All Programs</button>
        <button class="btn" onclick="showContactForm()">📨 Contact Admission Team</button>

        <!-- Payment Info -->
        <div id="allPaymentInfo" class="payment-info" style="display:none;">
          <p>To enroll in <strong>all programs</strong>, send <strong>KES 195,000</strong> via M-Pesa to:</p>
          <ul>
            <li><strong>Phone Number:</strong> 0724255124</li>
            <li><strong>Account Ref:</strong> Your Full Name</li>
          </ul>
        </div>

        <!-- Contact Form -->
        <div id="contactForm" class="contact-form" style="display:none;">
          <h3>📞 Contact Admissions Team</h3>
          <form action="send_contact.php" method="POST">
            <label for="fullname">Full Name:</label>
            <input name="fullname" id="fullname" required>
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required>
            <label for="phone">Phone Number:</label>
            <input name="phone" id="phone" required>
            <label for="programs">Programs Interested In:</label>
            <input name="programs" id="programs" placeholder="e.g., Cyber Security" required>
            <label for="message">Payment Confirmation Message:</label>
            <textarea name="message" id="message" rows="4" placeholder="MPESA Code: ABC123" required></textarea>
            <button type="submit" class="btn">Send Message</button>
          </form>
        </div>
      </div>

      <!-- Fee Report Section -->
     <div id="report" class="hidden-section">
  <?php if (!empty($_SESSION['is_admin'])): ?>
    <h3>📊 Fee Reports (Admin)</h3>
     <!-- 🔍 Search input -->
  <input type="text" id="searchInput" placeholder="🔍 Search by name, program or message..." style="width:100%;padding:10px;margin-bottom:10px;border-radius:5px;border:1px solid #ccc;font-size:1em;">

  <!-- 🔄 Refresh button -->
  <form method="post" style="display:inline;">
    <button type="submit" class="btn" style="background-color:#17a2b8;margin-bottom:10px;">🔄 Refresh</button>
  </form>
    <?= $reportContent ?>
    <script>
  document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#report table tr:not(:first-child)');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });
</script>

    <a href="?logout=1" class="btn">Logout Admin</a>

  <?php else: ?>
    
    <p>🔐 Admin access required. Please log in:</p>
    
    <form method="POST" style="margin-top:20px;">
      
      <input type="text" name="admin_username" placeholder="Username" required style="padding:8px; border-radius:4px;">
      <input type="password" name="admin_password" placeholder="Password" required style="padding:8px; border-radius:4px; margin-left:10px;">
      <button class="btn" type="submit" style="margin-left:10px;">Login</button>
    </form>
    <?php if ($loginError): ?>
      <p style="color:#ff3333; margin-top:10px;"><?= htmlspecialchars($loginError) ?></p>
    <?php endif; ?>

  <?php endif; ?>
</div>

    <!-- Scholarship Section -->
    <div class="section">
      <h2>Scholarship</h2>
      <ul>
        <li>Merit-Based Scholarship for students scoring A or A- in KCSE</li>
        <li>Continuing students with GPA above 3.8 qualify for 25% discount</li>
        <li>Full tuition waiver available for top performers per year</li>
        <li>Email transcript and motivation letter to <a href="mailto:scholarship@ictconsultancy.ac.ke" style="color:#ffd86e;">scholarship@ictconsultancy.ac.ke</a></li>
      </ul>
      <a href="scholarship.php" class="button-link">Apply for Scholarship</a>
    </div>
  </div>

  <script>
    function toggleSection(id) {
      ['structure','report'].forEach(sec => {
        const el = document.getElementById(sec);
        el.style.display = sec === id ? (el.style.display === 'block' ? 'none' : 'block') : 'none';
      });
    }
    function showAllPayment() {
      document.getElementById("allPaymentInfo").style.display = "block";
      document.getElementById("contactForm").style.display = "none";
    }
    function showContactForm() {
      document.getElementById("contactForm").style.display = "block";
      document.getElementById("allPaymentInfo").style.display = "none";
    }
  </script>
</body>
</html>
