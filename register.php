<?php
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];
$confirm = $_POST['confirm'];

if ($pass !== $confirm) {
    die("❌ Passwords do not match.");
}

// Check if username or email already exists
$check = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    $mysqli->close();
    die("⚠️ Username or Email already registered.");
}
$check->close();

// Hash the password (optional if you're doing a vulnerability demo)
$hashed = $pass; // store as-is for SQLi testing
// $hashed = password_hash($pass, PASSWORD_BCRYPT); // use this in real apps

$role = 'user';
$stmt = $mysqli->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $hashed, $role);

if ($stmt->execute()) {
    header("Location: login.html"); // ✅ Redirect to login page
    exit();
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
