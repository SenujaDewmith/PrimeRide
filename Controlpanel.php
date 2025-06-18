<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PrimeRide| Staff Login </title>
</head>
<body>

  <!-- Header -->
  <header class="p-3 text-bg-brown header">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="assets/Photo/logo.png" class="navlogo" alt="">
          </a>
          <h1>PrimeRide Control Panel</h1>
        </div>               
      </div>
    </div>
  </header>

<!-- Login Form -->

<div class="formst">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header">
            <h4>Admin/Staff Login</h4>
          </div>
          <div class="card-body">
            
            <?php
            session_start();
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            ?>
            <form method="POST" action="assets/php/StaffFunctions/staff_login.php">
              <div class="mb-3">
                <label for="staffUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="staffUsername" name="username" required placeholder="Enter your username">
              </div>
              <div class="mb-3">
                <label for="staffPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="staffPassword" name="password" required placeholder="Enter your password">
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php if (isset($_SESSION['success_message'])): ?>
<script>
  setTimeout(function() {
    window.location.href = "assets/php/StaffFunctions/staff_login.php";
  }, 2000); 
</script>
<?php endif; ?>


  <!-- Footer -->
  
    <div class="container text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Prime Ride</strong> <span>All Rights Reserved</span></p>
    </div>
  </footer>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
