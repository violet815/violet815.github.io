<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "ict_consultancy_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMsg = $errorMsg = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_application"])) {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $program = $_POST["program"];
    $submission_date = date("Y-m-d H:i:s");

    // File Uploads
    $id_attachment = $_FILES["id_attachment"]["name"];
    $credentials_attachment = $_FILES["credentials_attachment"]["name"];
    $target_dir = "uploads/";

    $id_path = $target_dir . basename($id_attachment);
    $cred_path = $target_dir . basename($credentials_attachment);

    if (move_uploaded_file($_FILES["id_attachment"]["tmp_name"], $id_path) &&
        move_uploaded_file($_FILES["credentials_attachment"]["tmp_name"], $cred_path)) {

        $stmt = $conn->prepare("INSERT INTO applications (fullname, email, program, id_attachment, credentials_attachment, submission_date)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname, $email, $program, $id_attachment, $credentials_attachment, $submission_date);

        if ($stmt->execute()) {
            $successMsg = "✅ Application submitted successfully.";
        } else {
            $errorMsg = "❌ Failed to save application.";
        }
        $stmt->close();
    } else {
        $errorMsg = "❌ Failed to upload files.";
    }
}

// Handle Admin Login
if (isset($_POST["admin_login"])) {
    $admin_user = $_POST["admin_user"];
    $admin_pass = $_POST["admin_pass"];
    if ($admin_user === "admin" && $admin_pass === "admin@123") {
        $_SESSION["admin_logged_in"] = true;
    } else {
        $errorMsg = "❌ Invalid admin credentials.";
    }
}

// Handle Logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: application_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ICT Consultancy Application Form</title>
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 95%;
            max-width: 850px;
            margin: 30px auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #00796B;
        }
        form input, form select {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }
        label {
            font-weight: bold;
        }
        .message {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .success { color: green; }
        .error { color: red; }

        .button {
            background: #00796B;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .button:hover {
            background: #004d40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #00796B;
            color: white;
        }
        .search-box {
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .refresh-btn {
            float: right;
            margin-bottom: 10px;
            background: #00897b;
        }
    </style>
</head>
<body>
  <a href="admissions.php" class="back-link">← Back to Admissions</a>
<div class="container">
    <h2>📌 ICT Consultancy Application Form</h2>

    <?php if (!isset($_SESSION["admin_logged_in"])): ?>
        <?php if (!empty($successMsg)): ?><div class="message success"><?= $successMsg ?></div><?php endif; ?>
        <?php if (!empty($errorMsg)): ?><div class="message error"><?= $errorMsg ?></div><?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Program of Interest:</label>
            <select name="program" required>
                <option value="">-- Select --</option>
                <option>Web Design</option>
                <option>Mobile App Development</option>
                <option>Cybersecurity</option>
                <option>Computer Maintenance</option>
                <option>Environmental Literacy</option>
            </select>

            <label>ID Attachment (PDF/Image):</label>
            <input type="file" name="id_attachment" accept=".pdf,.jpg,.png" required>

            <label>Education Credentials (PDF/Image):</label>
            <input type="file" name="credentials_attachment" accept=".pdf,.jpg,.png" required>

            <input type="submit" name="submit_application" class="button" value="Submit Application">
        </form>

        <hr>
        <h2>🔐 Admin Login</h2>
        <form method="post">
            <input type="text" name="admin_user" placeholder="Username" required>
            <input type="password" name="admin_pass" placeholder="Password" required>
            <input type="submit" name="admin_login" class="button" value="Login as Admin">
        </form>

    <?php else: ?>
        <h2>📋 Applications Report</h2>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Search applications..." style="width: 100%; padding: 10px; font-size: 1em;">
        </div>

        <button class="button refresh-btn" onclick="location.reload();">🔁 Refresh</button>

        <table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Program</th>
                <th>ID Attachment</th>
                <th>Credentials</th>
                <th>Submitted At</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM applications ORDER BY id DESC");
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['program']) ?></td>
                <td><a href="uploads/<?= $row['id_attachment'] ?>" target="_blank">View</a></td>
                <td><a href="uploads/<?= $row['credentials_attachment'] ?>" target="_blank">View</a></td>
                <td><?= date("F j, Y - g:i A", strtotime($row['submission_date'])) ?></td>
            </tr>
            <?php endwhile; else: ?>
            <tr><td colspan="7">No applications found.</td></tr>
            <?php endif; ?>
        </table>

        <a href="?logout=true" class="button" style="margin-top:20px;">← Logout</a>

        <!-- Search filter -->
        <script>
            document.getElementById("searchInput").addEventListener("keyup", function () {
                const value = this.value.toLowerCase();
                const rows = document.querySelectorAll("table tr:not(:first-child)");
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
                });
            });
        </script>
    <?php endif; ?>
</div>
</body>
</html>
