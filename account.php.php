<?php
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// ⚠️ This is vulnerable — it trusts the user-supplied ID with no checks
$account_id = $_GET['id'];

$query = "SELECT * FROM accounts WHERE id = $account_id"; // ⚠️ IDOR here
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo "<h2>Account Info</h2>";
    echo "<strong>Name:</strong> " . htmlspecialchars($data['first_name']) . " " . htmlspecialchars($data['last_name']) . "<br>";
    echo "<strong>Account Number:</strong> " . htmlspecialchars($data['account_number']) . "<br>";
    echo "<strong>Balance:</strong> ₹" . htmlspecialchars($data['deposit_amount']) . "<br>";
} else {
    echo "Account not found.";
}

$mysqli->close();
?>
