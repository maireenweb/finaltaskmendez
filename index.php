<?php
session_start();

$username = "";
$email = "";

$username_err = "";
$email_err = "";
$pass_err = "";
$Cpass_err = "";

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  // Fixed: assign to $username
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmed_pass = $_POST['Cpass'];

    if (empty($username)) {
        $username_err = "Username is required.";
        $error = true;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Email format invalid.";
        $error = true;
    }

    include "tools/db.php";
    $dbConnection = getDBConnection();

    $statement = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");
    $statement->bind_param("s", $email);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows > 0) {
        $email_err = "Email already used.";
        $error = true;
    }

    $statement->close();

    if (strlen($password) < 6) {
        $pass_err = "Password must be at least 6 characters.";
        $error = true;
    }

    if ($confirmed_pass != $password) {
        $Cpass_err = "Passwords do not match.";
        $error = true;
    }

    if (!$error) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');

        $statement = $dbConnection->prepare(
            "INSERT INTO users (username, email, password, createdAt) VALUES (?, ?, ?, ?)"
        );
        $statement->bind_param('ssss', $username, $email, $password, $created_at);
        $statement->execute();
        $insert_id = $statement->insert_id;
        $statement->close();

        $_SESSION["id"] = $insert_id;
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["created_at"] = $created_at;

        header("Location: login.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📚 Book Haven - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: url('file:///C:/xampp/htdocs/registration_system/bookcase-library-books-book-row-600nw-2484602235.webp') no-repeat center center fixed; /* Local image path */
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #6b4226;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #6b4226;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #f8f1e4;
            font-size: 16px;
        }

        button {
            margin-top: 20px;
            background-color: #6b4226;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4e2c1f;
        }

        @media screen and (max-width: 500px) {
            .form-container {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>📚 Register for Book Haven</h2>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" minlength="6" required>
            
            <label for="Cpass" class="label">Confirm Password</label>
            <input type="password" id="Cpass" name="Cpass" class="textbox" placeholder="Re-enter password here" required>
            <span style="color:red;"><?php echo $Cpass_err; ?></span><br><br>

            <button type="submit">Create Account</button>
        </form>
    </div>
</body>
</html>

