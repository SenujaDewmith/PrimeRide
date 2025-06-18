<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
}

.header {
  background-color: #343a40;
  color: white;
  padding: 1rem;
  position: relative;
  z-index: 1;
}

.header h1 {
  font-size: 1.8rem;
  margin-left: 1rem;
}

.navlogo {
  width: 50px;
  height: auto;
}

.header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.sidebar {
  height: calc(100vh - 70px);
  width: 220px;
  position: fixed;
  top: 70px;
  left: 0;
  background-color: #495057;
  padding-top: 20px;
  transition: 0.3s;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
}

.sidebar a {
  padding: 15px 25px;
  text-decoration: none;
  font-size: 18px;
  color: #f8f9fa;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  background-color: #343a40;
  color: #fff;
}

.sidebar a.active {
  background-color: #17a2b8;
  color: white;
  font-weight: bold;
}


.sidebar a::before {
  content: '•';
  color: #6c757d;
  margin-right: 10px;
  font-size: 20px;
  vertical-align: middle;
  display: inline-block;
}

.sidebar a:hover::before {
  color: #f8f9fa;
}

section {
  margin-left: 230px;
  padding: 20px;
  padding-top: 80px;
}


@media screen and (max-width: 768px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
    top: 0;
  }
  .sidebar a {
    text-align: center;
    padding: 10px;
  }
  section {
    margin-left: 0;
    padding-top: 120px;
  }
}

  </style>
</head>
<body>

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
            </div>
        </div>
    </div>
</header>

<!-- Sidebar -->
<div class="sidebar">
    <a href="vehiclemanagement.php">Vehicle Management</a>
    <a href="bookingmanagement.php">Booking Management</a>
    <a href="staffmanagement.php">Staff Management</a>
    <a href="gallerymanagement.php">Gallery Management</a>
    <a href="promotions.php">Promotions</a>
  </div>

  <!-- Main Content Area -->
  <div class="content">
    <h2>Staff Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">Add Staff Member</button>
    
    
    <!-- Staff view Function -->
    
    <?php
include '../assets/php/dbconnection.php'; 
$sql = "SELECT id, staffusername FROM staff";
$result = $conn->query($sql);

?>
<table class="table table-striped mt-3">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>

  <!-- Staff Delete Function -->

    <?php
    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['staffusername'] . "</td>";
            echo "<td><button class='btn btn-danger' onclick='deleteStaff(" . $row['id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No staff members found</td></tr>";
    }
    ?>
  </tbody>
</table>

<script>
  function deleteStaff(id) {
    if (confirm("Are you sure you want to delete this staff member?")) {
        window.location.href = '../assets/php/AdminFunctions/Deletestaff.php?id=' + id;
    }
  }
</script>

<?php
$conn->close(); // Close the database connection
?>

  </div>

  <!-- Add Staff Modal -->

  <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addStaffModalLabel">Add New Staff Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../assets/php/AdminFunctions/Addstaff.php" method="POST">
            <div class="mb-3">
              <label for="staff_id" class="form-label">Staff ID</label>
              <input type="text" class="form-control" id="staff_id" name="staff_id" required>
            </div>
            <div class="mb-3">
              <label for="staffusername" class="form-label">Username</label>
              <input type="text" class="form-control" id="staffusername" name="staffusername" required>
            </div>
            <div class="mb-3">
              <label for="staffpassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="staffpassword" name="staffpassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Staff Member</button>
          </form>
        </div>
      </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 Prime Ride. All Rights Reserved.</p>
</footer>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
