<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Connect to database
$mysqli = new mysqli("localhost", "root", "kali", "safesaw_bank", 3307);
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Fetch account number and deposit amount
$stmt = $mysqli->prepare("SELECT account_number, deposit_amount FROM accounts WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($account_number, $deposit_amount);
$stmt->fetch();
$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Balance | Safe Saw</title>

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

    .ex-header {
      padding: 120px 0 40px;
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

    .btn-home {
      margin-top: 20px;
      display: inline-block;
      text-decoration: none;
      font-weight: 500;
      color: #003366;
    }

    .btn-home:hover {
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
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.html#header">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.html#contact">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header -->
<header class="ex-header">
  <div class="container">
    <h1>Your Account Balance</h1>
    <p class="lead">Review your deposit and account details</p>
  </div>
</header>

<!-- Main Content -->
<section class="py-5">
  <div class="container">
    <div class="col-lg-6 offset-lg-3">
      <div class="card-box text-center">
        <h5 class="mb-4">💼 Account Details</h5>
        <p><strong>Account Number:</strong> <?php echo htmlspecialchars($account_number); ?></p>
        <p><strong>Deposit Amount:</strong> ₹<?php echo number_format($deposit_amount, 2); ?></p>
        <a href="profile.php" class="btn-home">← Back to Profile</a>
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
