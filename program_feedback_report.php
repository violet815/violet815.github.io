<?php
session_start();
require 'db.php'; // Make sure this connects to your correct database

$sql = "SELECT pf.*, ur.firstname, ur.lastname 
        FROM program_feedback pf
        JOIN user_reports ur ON pf.user_id = ur.user_id
        ORDER BY pf.submission_date DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Programs Feedback Report</title>
  <style>
    body {
      background: #e0f7fa;
      font-family: Arial, sans-serif;
    }
    h2 {
      text-align: center;
      color: #006064;
    }
    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: #ffffff;
    }
    th, td {
      border: 1px solid #004d40;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #00838f;
      color: white;
    }
  </style>
</head>
<body>
  <h2>📋 All Program Reflections Report</h2>
  <table>
    <tr>
      <th>User</th>
      <th>Program</th>
      <th>Reflection</th>
      <th>Date Submitted</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
      <td><?= htmlspecialchars($row['program_name']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['reflection'])) ?></td>
      <td><?= $row['submission_date'] ?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>
