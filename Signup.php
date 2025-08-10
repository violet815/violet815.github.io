<?php
session_start();
require 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST["firstname"]);
    $lname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fname, $lname, $email, $password);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Signup failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html><html><head><title>Signup</title>
<style>
body {
  background: url('https://i1.wp.com/azmind.com/demo/bootstrap-registration-forms/form-2/assets/img/backgrounds/2.jpg') center/cover fixed no-repeat;
  font-family: Arial;
  color: #fff;
}
.box {
  background: rgba(0, 0, 50, 0.7);
  width: 360px;
  padding: 35px;
  margin: 80px auto;
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0, 0, 50, 0.8);
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
  background: #007bff;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
}
a.button-link {
  display: inline-block;
  background: #00ccff;
  color: white;
  padding: 10px 15px;
  border-radius: 5px;
  text-decoration: none;
  margin-top: 10px;
  text-align: center;
}
a:hover {
  opacity: 0.9;
}
</style></head><body>
<div class="box">
<h2>Create Account</h2>
<?= isset($error) ? "<p style='color:red;'>$error</p>" : "" ?>
<?php if (isset($success) && $success): ?>
  <p style="color:lightgreen;">Signup successful!</p>
  <a class="button-link" href="login.php">Go to Login</a>
  <a class="button-link" href="homepage.php">Go to Homepage</a>
<?php else: ?>
<form method="post">
  <input name="firstname" placeholder="First Name" required>
  <input name="lastname" placeholder="Last Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Signup</button>
</form>
<p>Have an account? <a href="login.php" style="color:#00ccff;">Login</a></p>
<?php endif; ?>
</div></body></html>
