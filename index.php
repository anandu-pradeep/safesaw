<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Safe Saw</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome-all.min.css" rel="stylesheet">
    <link href="./css/aos.min.css" rel="stylesheet">
    <link href="./css/swiper.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link rel="icon" href="./assets/images/favicon.png">
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar-dark" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand logo-text" href="index.php">Safe Saw</a>

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#header">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="openaccount.html">Open Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="changepassword.html">Change Password</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false" href="#">Personal</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                           <li>
                              <a class="dropdown-item" href="<?php echo isset($_SESSION['user_id']) ? 'profile.php?id=' . $_SESSION['user_id'] : 'login.html'; ?>">
                                Profile
                              </a>
                           </li>


                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="terms.html">Balance Enquire</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="privacy.html">Apply Loan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div> <!-- end of navbar-collapse -->
        </div> <!-- end of container -->
    </nav> <!-- end of navbar -->
    <!-- Add your remaining HTML content (hero section, about, services, etc.) below this -->

    <!-- Scripts -->
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/purecounter.min.js"></script>
    <script src="./js/swiper.min.js"></script>
    <script src="./js/aos.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>
