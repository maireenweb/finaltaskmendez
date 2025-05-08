<?php
$host = "localhost";
$dbname = "registration_system";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password_hash'])) {
    header("Location: home.html");
    exit();
  } else {
    header("Location: login.html?error=Incorrect password");
    exit();
  }
} else {
  header("Location: login.html?error=User not found");
  exit();
}
?>
