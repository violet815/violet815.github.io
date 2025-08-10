<?php
session_start();
require 'init_db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT reflections.id, users.username, reflections.reflection, reflections.created_at
                        FROM reflections
                        JOIN users ON reflections.user_id = users.id
                        ORDER BY reflections.created_at DESC");
?>

<h2>📝 Student Reflections</h2>
<table boarder="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Reflection</th>
    <th>Date</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= nl2br(htmlspecialchars($row['reflection'])) ?></td>
    <td><?= $row['created_at'] ?></td>
  </tr>
  <?php endwhile; ?>
</table>
