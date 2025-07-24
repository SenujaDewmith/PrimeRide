<?php
session_start();

if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PrimeRide | Authentication</title>

  <style>
    body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.auth-section {
    max-width: 500px;
    margin: auto;
    margin-top: 500px;
    margin-bottom: 20px;
    padding-top: 20px;
    position: relative;
    z-index: 1;
}

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    border: none;
}

.card h4 {
    color: #333;
    margin-bottom: 20px;
}

.btnl {
    width: 120px;
}

.auth-form label {
    font-weight: bold;
}

.auth-form .form-label .text-danger {
    font-size: 0.85em;
    font-weight: normal;
}

.btn-primary,
.btn-outline-primary {
    border-radius: 20px;
}

#password-help {
    font-size: 0.9em;
    color: #6c757d;
}

input:invalid {
    border-color: #e3342f;
}

input:valid {
    border-color: #38c172;
}

@media (min-width: 768px) {
    .auth-section {
        margin-top: 350px;
    }
}

</style>
</head>

<body>

<?php include 'navigation.php'; ?>

<hr class="featurette-divider">
<section class="auth-section container ">
  <div class="card p-4  mt-md-1">
    <div class="text-center mb-3">
      <button id="login-tab" class="btn btnl btn-primary" onclick="switchForm('login')">Login</button>
      <button id="signup-tab" class="btn btnl btn-outline-primary" onclick="switchForm('signup')">Signup</button>
    </div>

    
    <?php if (isset($_SESSION['error'])): ?>
      <div id="alert-message" class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php elseif (isset($_SESSION['success'])): ?>
      <div id="alert-message" class="alert alert-success" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <div id="login-form" class="auth-form">
      <h4>Login</h4>
      <form method="POST" action="assets/php/UserFunctions/login.php">
        <div class="mb-3">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="text" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-success">Login</button>
      </form>
    </div>

    <div id="signup-form" class="auth-form d-none">
      <h4>Signup</h4>
      <form id="signupForm" method="POST" action="assets/php/UserFunctions/register.php" enctype="multipart/form-data">
       
        <div class="mb-3">
          <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
          <label for="signup-password" class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control" id="signup-password" required>
          <div id="password-help" class="form-text">Must be at least 8 characters long, contain one uppercase letter, and one special symbol.</div>
        </div>
        <div class="mb-3">
          <label for="confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
          <input type="password" name="confirm_password" class="form-control" id="confirm-password" required>
        </div>
        <div class="mb-3">
          <label for="profile-picture" class="form-label">Profile Picture (Optional)</label>
          <input type="file" name="profile_picture" class="form-control" id="profile-picture" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Signup</button>
      </form>
    </div>
  </div>
</section>

<?php include 'footer.php' ?>

<script src="assets/js/authentication.js"></script>
<script defer src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>