<?php
session_start();

// Connect to database
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("❌ Connection failed: " . $mysqli->connect_error);
}

// Generate 10-digit account number
$account_number = strval(rand(1000000000, 9999999999));

// Handle file upload
$upload_path = "";
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo_name = basename($_FILES['photo']['name']);
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $upload_path = "uploads/" . uniqid() . "_" . $photo_name;

    if (!move_uploaded_file($photo_tmp, $upload_path)) {
        die("❌ Failed to upload photo.");
    }
} else {
    die("❌ Photo upload error.");
}

// Prepare statement with deposit_amount
$stmt = $mysqli->prepare("INSERT INTO accounts 
    (first_name, last_name, dob, address, aadhar, phone, photo, account_type, account_number, deposit_amount) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("❌ Prepare failed: " . $mysqli->error);
}

// Bind parameters including deposit
$stmt->bind_param(
    "sssssssssd",
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['dob'],
    $_POST['address'],
    $_POST['aadhar'],
    $_POST['phone'],
    $upload_path,
    $_POST['account_type'],
    $account_number,
    $_POST['deposit']
);

if ($stmt->execute()) {
    $id = $stmt->insert_id;
    $_SESSION['user_id'] = $id;

    // Redirect to profile page
    header("Location: profile.php?id=$id");
    exit();
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
