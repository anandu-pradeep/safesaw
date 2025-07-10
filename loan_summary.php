<?php
session_start();
if (!isset($_SESSION['loan_account'])) {
    echo "❌ No loan data available.";
    exit();
}

$loan = $_SESSION['loan_account'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loan Summary</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <div class="card shadow p-4">
    <h3 class="mb-4">✅ Loan Application Summary</h3>
    <p><strong>Account Number:</strong> <?php echo $loan['account_number']; ?></p>
    <p><strong>Loan Amount:</strong> ₹<?php echo number_format($loan['amount'], 2); ?></p>
    <p><strong>Repayment Period:</strong> <?php echo $loan['period']; ?> months</p>
    <p><strong>Interest (2%):</strong> ₹<?php echo number_format($loan['interest'], 2); ?></p>
    <a href="index.html" class="btn btn-primary mt-3">Back to Home</a>
  </div>
</div>

</body>
</html>
