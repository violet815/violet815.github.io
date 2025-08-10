<?php
session_start();
$conn = new mysqli("localhost", "root", "", "report_for_admin");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once('tcpdf/tcpdf.php'); // TCPDF should be in same folder or correctly referenced

// -------------------- Handle Logout --------------------
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_program_report.php");
    exit();
}

// -------------------- Handle Signup --------------------
if (isset($_POST['signup'])) {
    $name = trim($_POST['admin_name']);
    $pass = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE admin_name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $stmtInsert = $conn->prepare("INSERT INTO admin_users (admin_name, admin_password) VALUES (?, ?)");
        $stmtInsert->bind_param("ss", $name, $pass);
        $stmtInsert->execute();
        $success = "✅ Admin created. Please log in.";
    } else {
        $error = "❌ Admin already exists.";
    }
}

// -------------------- Handle Login --------------------
if (isset($_POST['login'])) {
    $name = trim($_POST['admin_name']);
    $pass = trim($_POST['admin_password']);

    $stmt = $conn->prepare("SELECT id, admin_password FROM admin_users WHERE admin_name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($admin_id, $hashed);
        $stmt->fetch();

        if (password_verify($pass, $hashed)) {
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $name;
            header("Location: admin_program_report.php");
            exit();
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ Admin not found.";
    }
}

// -------------------- Handle PDF --------------------
if (isset($_POST['generate_pdf']) && isset($_SESSION['admin_id'])) {
    $sql = "SELECT pf.*, ur.firstname, ur.lastname 
            FROM program_forms pf
            JOIN user_reports ur ON pf.user_id = ur.user_id
            ORDER BY pf.submission_date DESC";
    $result = $conn->query($sql);

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    $html = '<h2 style="text-align:center;">📋 Program Form Submissions Report</h2>
             <table border="1" cellpadding="4">
             <thead>
             <tr>
                 <th>#</th><th>User Name</th><th>Email</th><th>Program</th>
                 <th>Interest</th><th>Expectations</th><th>Challenges</th><th>Suggestions</th><th>Date</th>
             </tr></thead><tbody>';

    if ($result && $result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $html .= "<tr>
                <td>{$count}</td>
                <td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['program']) . "</td>
                <td>" . htmlspecialchars($row['interest']) . "</td>
                <td>" . htmlspecialchars($row['expectations']) . "</td>
                <td>" . htmlspecialchars($row['challenges']) . "</td>
                <td>" . htmlspecialchars($row['suggestions']) . "</td>
                <td>" . htmlspecialchars($row['submission_date']) . "</td>
            </tr>";
            $count++;
        }
    } else {
        $html .= "<tr><td colspan='9'>No submissions found.</td></tr>";
    }

    $html .= '</tbody></table>';
    $pdf->writeHTML($html);
    $pdf->Output('Program_Form_Report.pdf', 'I');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Report</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('https://images.unsplash.com/photo-1535223289827-42f1e9919769') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .container {
            background-color: rgba(0,0,0,0.7);
            padding: 30px;
            max-width: 95%;
            margin: 30px auto;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #ffd700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            color: #000;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #ffd700;
        }
        .form-box {
            background: #ffffff22;
            padding: 20px;
            margin: 20px auto;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
        }
        button {
            background: #ffd700;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            color: #ffd700;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['admin_id'])): ?>
    <div class="form-box">
        <h2>🔐 Admin Login</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p style='color:lightgreen;'>$success</p>"; ?>
        <form method="post">
            <label>Admin Name:</label>
            <input type="text" name="admin_name" required>
            <label>Password:</label>
            <input type="password" name="admin_password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <hr>
        <h3>📝 Create Admin</h3>
        <form method="post">
            <label>New Admin Name:</label>
            <input type="text" name="admin_name" required>
            <label>Password:</label>
            <input type="password" name="admin_password" required>
            <button type="submit" name="signup">Signup</button>
        </form>
    </div>
<?php else: ?>
    <div class="container">
        <h2>📋 Program Form Submissions Report</h2>
        <p>Welcome, <strong><?php echo $_SESSION['admin_name']; ?></strong> | <a href="?logout=1">Logout</a></p>

        <form method="POST" style="margin-bottom: 20px;">
            <button type="submit" name="generate_pdf">📄 Generate PDF</button>
        </form>

        <table>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Program</th>
                <th>Interest</th>
                <th>Expectations</th>
                <th>Challenges</th>
                <th>Suggestions</th>
                <th>Submitted</th>
            </tr>
            <?php
            $sql = "SELECT pf.*, ur.firstname, ur.lastname, ur.email
                    FROM program_forms pf
                    JOIN user_reports ur ON pf.user_id = ur.user_id
                    ORDER BY pf.submission_date DESC";
            $result = $conn->query($sql);
            $count = 1;

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$count}</td>
                        <td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['program']) . "</td>
                        <td>" . htmlspecialchars($row['interest']) . "</td>
                        <td>" . htmlspecialchars($row['expectations']) . "</td>
                        <td>" . htmlspecialchars($row['challenges']) . "</td>
                        <td>" . htmlspecialchars($row['suggestions']) . "</td>
                        <td>" . htmlspecialchars($row['submission_date']) . "</td>
                    </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='9'>No submissions found.</td></tr>";
            }
            ?>
        </table>

        <h2 style="margin-top:50px">🗒️ Program Feedback Reflections</h2>
        <table>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Program</th>
                <th>Reflection</th>
                <th>Date Submitted</th>
            </tr>
            <?php
            $sql = "SELECT pf.*, ur.firstname, ur.lastname
                    FROM program_feedback pf
                    JOIN user_reports ur ON pf.user_id = ur.user_id
                    ORDER BY pf.submission_date DESC";
            $result = $conn->query($sql);
            $count = 1;

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$count}</td>
                        <td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>
                        <td>" . htmlspecialchars($row['program_name']) . "</td>
                        <td>" . nl2br(htmlspecialchars($row['reflection'])) . "</td>
                        <td>" . htmlspecialchars($row['submission_date']) . "</td>
                    </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='5'>No feedback found.</td></tr>";
            }
            ?>
        </table>
    </div>
<?php endif; ?>

</body>
</html>
