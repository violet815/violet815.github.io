<?php
$conn = new mysqli("localhost", "root", "", "ict_consultancy_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $conn->real_escape_string($_POST['fullname'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$phone = $conn->real_escape_string($_POST['phone'] ?? '');
$programs = $conn->real_escape_string($_POST['programs'] ?? '');
$message = $conn->real_escape_string($_POST['message'] ?? '');

$sql = "INSERT INTO contact_submissions (fullname, programs, message, created_at)
        VALUES ('$fullname', '$programs', '$message', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✅ Your message has been submitted successfully.</p>";
    echo "<a href='admissions.php'>← Back to Admissions</a>";
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
?>
