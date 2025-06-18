<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
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

.btn {
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

<!-- navigation bar -->
<?php include 'navigation.php'; ?>

<hr class="featurette-divider">
<section class="auth-section container mt-5">
  <div class="card p-4">
    <div class="text-center mb-3">
      <button id="login-tab" class="btn btn-primary" onclick="switchForm('login')">Login</button>
      <button id="signup-tab" class="btn btn-outline-primary" onclick="switchForm('signup')">Signup</button>
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
          <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
          <input type="text" name="username" class="form-control" id="username" required>
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
          <label for="signup-username" class="form-label">Username <span class="text-danger">*</span></label>
          <input type="text" name="username" class="form-control" id="signup-username" required>
        </div>
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

<!-- Footer -->
<?php include 'footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="assets/js/blockinspect.js"></script>
<script src="assets/js/authentication.js"></script>
</body>

</html>