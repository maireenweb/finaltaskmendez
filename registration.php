<?php
$host = 'localhost';
$dbname = 'user_registration'; // change if your DB name is different
$username = 'root';
$password = ''; // default password for root in XAMPP is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    // Basic validation
    if (empty($uname) || empty($email) || empty($pass)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (strlen($pass) < 6) {
        die("Password must be at least 6 characters.");
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        die("This email is already registered.");
    }

    // Hash the password
    $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

    if ($stmt->execute([$uname, $email, $passwordHash])) {
        echo "✅ Registration successful!";
    } else {
        echo "❌ Something went wrong. Please try again.";
    }
}
?>
