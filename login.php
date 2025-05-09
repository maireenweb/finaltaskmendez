<?php
session_start();

$username = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username and/or Password is required.";
    } else {
        include "tools/db.php";
        $dbConnection = getDBConnection();

        $statement = $dbConnection->prepare(
            "SELECT id, email, password, createdAt FROM users WHERE username = ?"
        );
        $statement->bind_param('s', $username);
        $statement->execute();
        $statement->bind_result($id, $email, $stored_password, $createdAt);

        if ($statement->fetch()) {
            if (password_verify($password, $stored_password)) {
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["createdAt"] = $createdAt;

                header("location: ./home.php");
                exit;
            }
        }

        $statement->close();

        $error = "Username or Password Invalid";
    }
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bookstore Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f8f1e4;
      padding-top: 50px;
    }
    .login-container {
      background: #ffffff;
      padding: 20px;
      width: 300px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    h2 {
      color: #6b4226;
    }
    input {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      background-color: #6b4226;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }
    #errorMessage {
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>📚 Book Haven Login</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Enter username" required /><br />
      <input type="password" name="password" placeholder="Enter password" required /><br />
      <button type="submit">Login</button>
      <p id="errorMessage"><?php echo htmlspecialchars($error); ?></p>
    </form>
  </div>
</body>
</html>
