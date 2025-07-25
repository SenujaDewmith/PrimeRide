<?php include '../assets/php/dbconnection.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="staff.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PrimeRide | Staff Dashboard</title>
</head>

<body>

  <?php include 'components/staff_sidebar.php';?>
  <!-- Dashboard -->
  <div class="container my-5">
    <h1 class="text-center">Staff Dashboard</h1>
    <div class="text-center my-4">
      <a href="booking_management.php" class="btn btn-outline-primary btn-lg mx-2">Booking Management</a>
      <a href="gallery_management.php" class="btn btn-outline-success btn-lg mx-2">Gallery Management</a>
    </div>

  <!-- Logout Confirmation Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to logout?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <a href="../assets/php/StaffFunctions/staff_logout.php" class="btn btn-danger">Yes, Logout</a>
        </div>
      </div>
    </div>
  </div>

  <footer id="footer" class="footer dark-background">
    <div class="container">
      <div class="row gy-3">
      </div>
    </div>
    <hr class="featurette-divider">
    <div class="container text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">PrimeRide</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href=""></a>
      </div>
    </div>
  </footer>

  <script defer src="../assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
