<?php

$is_logged_in = isset($_SESSION['username']) || isset($_COOKIE['username']);
?>
<link rel="stylesheet" href="assets/css/main_header.css">

<!-- Header -->
<header class="p-3 text-bg-brown header">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="assets/Photo/Logo.png" class="navlogo" alt="">
                </a>
                <h1>Prime Ride Car Rental</h1>
            </div>
            <div class="d-flex align-items-center ms-auto">
                <div class="text-end">
                    <?php if ($is_logged_in): ?>
                        
                        <a href="profile.php"><button type="button" class="btn btn-outline-light me-2">My Account</button></a>
                    <?php else: ?>
                        
                        <a href="authentication.php"><button type="button" class="btn btn-warning">Login / Sign-up</button></a>
                        <a href="Controlpanel.php"><button type="button" class="btn btn-warning">Admin Login</button></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
<hr class="featurette-divider">
<div class="submenudirect-wrapper">
    <div class="container submenudirect">
        <header class="d-flex justify-content-py-5">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>        
                <li class="nav-item"><a href="rent-car.php" class="nav-link">Select A Vehicle</a></li>
                <li class="nav-item"><a href="Specialoffers.php" class="nav-link">Offers</a></li>              
                <li class="nav-item"><a href="Aboutus.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link">FAQ</a></li>
                <li class="nav-item"><a href="Contactus.php" class="nav-link">Contact Us</a></li>
            </ul>
        </header>
    </div>
</div>
