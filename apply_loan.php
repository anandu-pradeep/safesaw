<?php
session_start();

// ✅ SIMULATE DoS if Address field says "KERALA"
if (
    (isset($_POST['simulate_dos']) && $_POST['simulate_dos'] === '1') ||
    (isset($_POST['address']) && strtolower(trim($_POST['address'])) === 'kerala')
) {
    $start = microtime(true);
    while (microtime(true) - $start < 10) {
        for ($i = 0; $i < 10000000; $i++) {
            hash('sha256', rand());
        }
    }

    http_response_code(503);
    echo "
    <html><head><title>Server Overloaded</title>
    <style>
      body { background: #fff0f0; text-align: center; font-family: Arial; padding-top: 100px; }
      h1 { font-size: 28px; color: red; }
      p { font-size: 18px; }
    </style>
    </head><body>
      <h1>🚫 Server Overloaded</h1>
      <p>The system is under heavy load. Please try again later.</p>
    </body></html>";
    exit(); // 🛑 Stop execution
}

// ✅ DB Connection
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// ✅ File Upload
$upload_path = "uploads/";
if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

if (isset($_FILES['aadhar_image']) && $_FILES['aadhar_image']['error'] === UPLOAD_ERR_OK) {
    $aadhar_image_name = basename($_FILES['aadhar_image']['name']);
    $aadhar_tmp = $_FILES['aadhar_image']['tmp_name'];
    $aadhar_image_path = $upload_path . uniqid() . "_" . $aadhar_image_name;

    if (!move_uploaded_file($aadhar_tmp, $aadhar_image_path)) {
        die("❌ Failed to upload Aadhar image.");
    }
} else {
    die("❌ No Aadhar image uploaded or upload error.");
}

// ✅ Get Form Data
$name = $_POST['name'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$aadhar = $_POST['aadhar'];
$amount = (float) $_POST['amount'];
$period = (int) $_POST['period'];

// ✅ Validate limit
if ($amount > 50000) {
    die("❌ Loan amount must be ₹50,000 or less.");
}

$interest = 0.02 * $amount;
$account_number = rand(1000000000, 9999999999);

// ✅ Insert into DB
$stmt = $mysqli->prepare("INSERT INTO loans (name, dob, address, aadhar, aadhar_image, amount, period, interest, account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("❌ Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("ssssssddd", $name, $dob, $address, $aadhar, $aadhar_image_path, $amount, $period, $interest, $account_number);

if ($stmt->execute()) {
    $_SESSION['loan_account'] = [
        'account_number' => $account_number,
        'amount' => $amount,
        'period' => $period,
        'interest' => $interest
    ];
    header("Location: loan_summary.php");
    exit();
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
