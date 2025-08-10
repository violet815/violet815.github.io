<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, firstname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($uid, $fname, $hash);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION["user_id"] = $uid;
            $_SESSION["firstname"] = $fname;
            header("Location: homepage.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html><html><head><title>Login</title>
<style>
body {
  background: url('https://wallpaperaccess.com/full/2276922.jpg') center/cover fixed no-repeat;
  font-family: Arial;
  color: #fff;
}
.box {
  background: rgba(0, 0, 80, 0.75);
  width: 360px;
  padding: 35px;
  margin: 100px auto;
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0, 0, 50, 0.9);
}
input, button {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: none;
  border-radius: 6px;
  font-size: 16px;
}
input {
  background: #f0f8ff;
  color: #000;
}
button {
  background: #0055cc;
  color: white;
  font-weight: bold;
  cursor: pointer;
}
a {
  color: #00ccff;
}
a:hover {
  text-decoration: underline;
}
</style></head><body>
<div class="box">
<h2>Login</h2>
<?php if (!empty($error)): ?>
  <p style="color:red;"><?= $error ?></p>
<?php endif; ?>
<form method="POST">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>
<p>No account? <a href="signup.php">Signup</a></p>
</div></body></html>
