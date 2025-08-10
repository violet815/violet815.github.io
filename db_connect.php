<?php
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = "";     // default is no password in XAMPP
$dbname = "mobile_learning_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}
?>
