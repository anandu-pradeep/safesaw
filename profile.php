<?php
session_start();

// Connect to database
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get user ID from session or fallback
$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0);

// Redirect or show error if no valid ID
if ($id === 0) {
    echo "<h3>User not found!</h3>";
    exit();
}

// Fetch user details
$stmt = $mysqli->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$mysqli->close();

if (!$user) {
    echo "<h3>User not found!</h3>";
    exit();
}

// Mask account number
$masked_account = str_repeat("X", 6) . substr($user['account_number'], -4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile | Safe Saw</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts & Styles -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/fontawesome-all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
    }

    .navbar {
      background-color: #003366;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 24px;
    }

    .profile-header {
      padding: 100px 0 40px;
      background-color: #003366;
      color: white;
      text-align: center;
    }

    .card-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .footer {
      background-color: #003366;
      color: white;
      padding: 20px 0;
    }

    .footer i {
      margin-left: 10px;
    }

    .img-thumbnail {
      max-width: 100%;
      border-radius: 10px;
    }

    .back-home {
      color: #0d6efd;
      font-weight: 500;
      text-decoration: none;
    }

    .back-home:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.html">Safe Saw</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Header -->
<header class="profile-header">
  <div class="container">
    <h1>User Profile</h1>
    <p class="lead">Your personal account information</p>
  </div>
</header>

<!-- Profile Card -->
<section class="py-5">
  <div class="container">
    <div class="card-box">
      <div class="row">
        <div class="col-md-4 text-center mb-3">
          <img src="<?= htmlspecialchars($user['photo']) ?>" alt="User Photo" class="img-thumbnail shadow">
        </div>
        <div class="col-md-8">
          <p><strong>ID:</strong> <?= $user['id'] ?></p>
          <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></p>
          <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['dob']) ?></p>
          <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
          <p><strong>Aadhar Number:</strong> <?= htmlspecialchars($user['aadhar']) ?></p>
          <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
          <p><strong>Account Type:</strong> <?= ucfirst(htmlspecialchars($user['account_type'])) ?></p>
          <p><strong>Account Number:</strong> <?= $masked_account ?></p>
          <p><strong>Created At:</strong> <?= $user['created_at'] ?></p>
        </div>
      </div>
      <div class="text-center mt-4">
        <a href="index.html" class="back-home"><i class="fas fa-home"></i> Back to Home</a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer text-center">
  <div class="container d-flex justify-content-between">
    <p class="mb-0">© 2025 Safe Saw</p>
    <div>
      <i class="fab fa-cc-visa"></i>
      <i class="fab fa-cc-mastercard"></i>
      <i class="fab fa-cc-paypal"></i>
      <i class="fab fa-cc-amazon-pay"></i>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
