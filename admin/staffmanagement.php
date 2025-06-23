<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/management.css"/>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  
  <script defer src="../assets/js/bootstrap.bundle.min.js"></script>

</head>
<body>

  <!-- header -->
<?php include 'components/admin_header.php'; ?>

  
<!-- Sidebar -->
<?php include 'components/admin_sidebar.php';?>


  <!-- Main Content Area -->
  <div class="content min-vh-100">
    <h2>Staff Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">Add Staff Member</button>
    
    
    <!-- Staff view Function -->
    
    <?php
include '../assets/php/dbconnection.php'; 
$sql = "SELECT id, username FROM staff";
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
            echo "<td>" . $row['username'] . "</td>";
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

<?php include 'components/admin_footer.php'; ?>

</body>
</html>
