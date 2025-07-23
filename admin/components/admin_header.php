<!-- admin_header.php -->

<link rel="stylesheet" href="css/header.css">

<header class="p-3 text-bg-brown header">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img src="../assets/Photo/logo.png" class="navlogo" alt="">
        </a>
        <h1>Prime Ride Admin Dashboard</h1>
      </div>
      <div class="d-flex align-items-center ms-auto">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
          Logout
        </button>
      </div>
    </div>
  </div>
</header>

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
        <a href="../assets/php/AdminFunctions/AdminLogout.php" class="btn btn-danger">Yes, Logout</a>
      </div>
    </div>
  </div>
</div>


