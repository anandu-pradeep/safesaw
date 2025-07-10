<?php
session_start();

// Connect to DB
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// ✅ Simulated SQL Injection condition (demo only)
if (stripos($username, 'OR 1=1') !== false || stripos($username, "' OR") !== false) {
    // Force random user selection
    $randomQuery = "SELECT id FROM users ORDER BY RAND() LIMIT 1";
    $randResult = $mysqli->query($randomQuery);
    
    if ($randResult && $randResult->num_rows > 0) {
        $randomId = $randResult->fetch_assoc()['id'];
        $query = "SELECT * FROM users WHERE id = $randomId";
    } else {
        die("❌ No users found to simulate SQL injection.");
    }
} else {
    // ❌ Vulnerable query (no sanitization)
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
}

echo "<pre>DEBUG SQL: $query</pre>"; // Show query for demo

$result = $mysqli->query($query) or die("SQL Error: " . $mysqli->error);

if ($result && $result->num_rows >= 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    echo "<script>console.log('✅ Logged in as: {$row['username']} (ID: {$row['id']}, Role: {$row['role']})');</script>";

    // ✅ Redirect to admin or user dashboard
    if ($row['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.html");
    }
    exit();
} else {
    echo "❌ Invalid login.";
}

$mysqli->close();
?>
