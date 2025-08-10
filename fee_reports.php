<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admission Contact Reports</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f3;
      padding: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    h2 {
      text-align: center;
    }
  </style>
</head>
<body>

<h2>📊 Fee Reports (Admin)</h2>

<?php
$conn = new mysqli("localhost", "root", "", "ict_consultancy_portal");

if ($conn->connect_error) {
  echo "<p style='color:red;'>Database connection failed.</p>";
} else {
  $sql = "SELECT fullname, programs, message, created_at FROM contact_submissions ORDER BY created_at DESC";
  $res = $conn->query($sql);

  if ($res && $res->num_rows > 0) {
    echo "<table>
            <tr>
              <th>Full Name</th>
              <th>Program</th>
              <th>Message</th>
              <th>Date Submitted</th>
            </tr>";
    while ($r = $res->fetch_assoc()) {
      echo "<tr>
              <td>" . htmlspecialchars($r['fullname']) . "</td>
              <td>" . htmlspecialchars($r['programs']) . "</td>
              <td>" . nl2br(htmlspecialchars($r['message'])) . "</td>
              <td>" . htmlspecialchars($r['created_at']) . "</td>
            </tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No reports submitted yet.</p>";
  }

  $conn->close();
}
?>

</body>
</html>
