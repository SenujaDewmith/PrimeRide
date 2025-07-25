<?php include '../assets/php/dbconnection.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/management.css"/>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>

<!-- header -->
<?php include 'components/admin_header.php'; ?>

<!-- Sidebar -->
<?php include 'components/admin_sidebar.php';?>
    

<div class="content min-vh-100">
    <h2>Vehicle Management</h2>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">Add New Vehicle</button>
    
    <button class="btn btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#dateRangeModal">
    <strong>Rented / Booked Vehicles Report</strong>
    </button>

    <button class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#dateRangeModal2">
    <strong>Available Vehicles Report</strong>
    </button>


<div class="row mt-4">
    <?php
        // SQL query that fetch vehicles from the db, including price_perday
        $sql = " SELECT v.id, v.model, v.seats, v.fuel_type, v.transmission, 
                v.license_plate, v.image_path, v.price_perday, v.vehicle_make, v.vehicle_type,
                EXISTS (SELECT 1 FROM rental 
                WHERE rental.vehicle_id = v.id 
                AND rental.rental_status IN ('Payment pending', 'approved')) 
                AS is_rented FROM vehicles v";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $vehicleName = $row['vehicle_make']." ". $row['model'];
    ?>
            <div class="col-md-4 mb-4">
                    <div class="card car-card">
                        <img src="../assets/Photo/Vehicleimg/<?php echo $row['image_path']; ?>" class="card-img-top"
                             alt="<?php echo $vehicleName; ?>">
                             
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $vehicleName; ?></h5>
                            <!-- <p class="card-text"><?php echo $row['model']; ?> - Spacious and comfortable. Perfect for family trips.</p> -->
                            <ul class="list-unstyled">
                                <li><strong>Make:</strong> <?php echo $row['vehicle_make'];?></li> 

                                <li><strong>Type:</strong> <?php echo $row['vehicle_type']; ?></li>
                                <li><strong>Seats:</strong> <?php echo $row['seats']; ?></li>
                                <li><strong>Fuel Type:</strong> <?php echo $row['fuel_type']; ?></li>
                                <li><strong>Transmission:</strong> <?php echo $row['transmission']; ?></li>
                                <li><strong>License Plate:</strong> <?php echo $row['license_plate']; ?></li>
                                <li><strong>Price per Day:</strong> LKR <?php echo number_format($row['price_perday'], 2); ?></li> 
                            </ul>

                            <form action="../assets/php/AdminFunctions/DeleteVehicle.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" <?php echo $row['is_rented'] ? 
                                'disabled title="Vehicle is rented or has a pending request"' : ''; ?>>Delete</button>
                            </form>

                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateVehicleModal"
                                onclick="populateUpdateModal(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                                <?php echo ($row['is_rented'] ? 'disabled title="This vehicle is currently rented or requested."' : ''); ?>>
                                Update
                            </button>
                            <?php if ($row['is_rented']): ?>
                                <span class="badge bg-secondary mt-2">Rented / Requested</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php
                }
        } else {
            echo "<p>No vehicles available.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>


<!-- Add Vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVehicleModalLabel">Add New Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../assets/php/AdminFunctions/AddVehicle.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="vehiclMake" class="form-label">Vehicle Make</label>
                        <select class="form-select" id="vehicleMake" name="vehicle_make" required>
                            <option value="">--Select Vehicle Make</option>
                            <option value="BMW">BMW</option>
                            <option value="BENZ">BENZ</option>
                            <option value="Toyota">TOYOTA</option>
                            <option value="Nissan">NISSAN</option>
                            <option value="Toyota">HONDA</option>
                            <option value="Toyota">MITZUBISHI</option>
                            <option value="Mazda">MAZDA</option>
                            <option value="Suzuki">SUZUKI</option>
                            <option value="Peradua">PERODUA</option>
                            <option value="Hyundai">HYUNDAI</option>
                            <option value="KIA">KIA</option>
                            <option value="Bajaj">BAJAJ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                        <small class="form-text text-muted">Only letters, numbers, and hyphen (-) allowed</small>
                    </div>

                    <div class="mb-3">
                        <label for="vehicleType" class="form-label">Vehicle Type</label>
                        <select class="form-select" id="vehicleType" name="vehicle_type" required>
                            <option value="">--Select Vehicle Type--</option>
                            <option value="Car">CAR</option>
                            <option value="Van">VAN</option>
                            <option value="Suv">SUV</option>
                            <option value="Mini-Van">MINI-VAN</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="seats" class="form-label">Seats</label>
                        <input type="number" class="form-control" id="seats" name="seats" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="fuelType" class="form-label">Fuel Type</label>
                        <select class="form-select" id="fuelType" name="fuel_type" required>
                            <option value="">-- Select Fuel Type --</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission</label>
                        <select class="form-select" id="transmission" name ="transmission" required>
                            <option value="">--Select Transmission Type--</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="licensePlate" class="form-label">License Plate</label>
                        <input type="text" class="form-control" id="licensePlate" name="license_plate" placeholder="Ex-AB-1111" required >
                        <small class="form-text text-muted">Only letters, numbers, and hyphen (-) allowed</small>
                    </div>

                    <div class="mb-3">
                        <label for="pricePerDay" class="form-label">Price per Day (LKR)</label>
                        <input type="number" step="100" class="form-control" id="pricePerDay" name="price_perday" min="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="imagePath" class="form-label">Vehicle Image</label>
                        <input type="file" class="form-control" id="imagePath" name="image_path" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Vehicle Modal -->
<div class="modal fade" id="updateVehicleModal" tabindex="-1" aria-labelledby="updateVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateVehicleModalLabel">Update Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateVehicleForm" method="POST" action="../assets/php/AdminFunctions/UpdateVehicle.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="update_vehicle_id" value="">

                    <div class="mb-3">
                        <label for="update_vehicle_make" class="form-label">Vehicle Make</label>
                        <select class="form-select" id="update_vehicle_make" name="vehicle_make" required>
                            <option value="">--Select Vehicle Make</option>
                            <option value="BMW">BMW</option>
                            <option value="BENZ">BENZ</option>
                            <option value="Toyota">TOYOTA</option>
                            <option value="Nissan">NISSAN</option>
                            <option value="Toyota">HONDA</option>
                            <option value="Toyota">MITZUBISHI</option>
                            <option value="Mazda">MAZDA</option>
                            <option value="Suzuki">SUZUKI</option>
                            <option value="Peradua">PERODUA</option>
                            <option value="Hyundai">HYUNDAI</option>
                            <option value="KIA">KIA</option>
                            <option value="Bajaj">BAJAJ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="update_model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="update_model" name="model" required>
                        <small class="form-text text-muted">Only letters, numbers, and hyphen (-) allowed</small>
                    </div>

                    <div class="mb-3">
                        <label for="update_vehicle_type" class="form-label">Vehicle Type</label>
                        <select class="form-select" id="update_vehicle_type" name="vehicle_type" required>
                            <option value="">--Select Vehicle Type--</option>
                            <option value="Car">CAR</option>
                            <option value="Van">VAN</option>
                            <option value="SUV">SUV</option>
                            <option value="Mini-Van">MINI-VAN</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="update_seats" class="form-label">Seats</label>
                        <input type="number" class="form-control" id="update_seats" name="seats" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="update_fuel_type" class="form-label">Fuel Type</label>
                        <select class="form-select" id="update_fuel_type" name="fuel_type" required>
                            <option value="">-- Select Fuel Type --</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="update_transmission" class="form-label">Transmission</label>
                        <select class="form-select" id="update_transmission" name ="transmission" required>
                            <option value="">--Select Transmission Type--</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="update_license_plate" class="form-label">License Plate</label>
                        <input type="text" class="form-control" id="update_license_plate" name="license_plate" required>
                        <small class="form-text text-muted">Only letters, numbers, and hyphen (-) allowed</small>
                    </div>
                    <div class="mb-3">
                        <label for="update_price_perday" class="form-label">Price per Day (LKR)</label>
                        <input type="number" step="0.01" class="form-control" id="update_price_perday" name="price_perday" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_image_path" class="form-label">Vehicle Image</label>
                        <input type="file" class="form-control" id="update_image_path" name="image_path" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Date Range Modal for rented vehicles -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="../assets/php/AdminFunctions/GenerateRentedVehiclesReport.php" target="_blank" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="from_date" class="form-label">From Date</label>
          <input type="date" id="from_date_rented" name="from_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="to_date" class="form-label">To Date</label>
          <input type="date" id="to_date_rented" name="to_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate Report</button>
      </div>
    </form>
  </div>
</div>


<!-- Date Range Modal for Available vehicles -->
<div class="modal fade" id="dateRangeModal2" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="../assets/php/AdminFunctions/GenerateAvailableVehiclesReport.php" target="_blank" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="from_date" class="form-label">From Date</label>
          <input type="date" id="from_date_available" name="from_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="to_date" class="form-label">To Date</label>
          <input type="date" id="to_date_available" name="to_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate Report</button>
      </div>
    </form>
  </div>
</div>

<script>
    //JavaScript to Update Modal
    function populateUpdateModal(vehicle) {
        document.getElementById('update_vehicle_id').value = vehicle.id;
        document.getElementById('update_vehicle_make').value = vehicle.vehicle_make;
        document.getElementById('update_model').value = vehicle.model;
        document.getElementById('update_vehicle_type').value = vehicle.vehicle_type;
        document.getElementById('update_seats').value = vehicle.seats;
        document.getElementById('update_fuel_type').value = vehicle.fuel_type;
        document.getElementById('update_transmission').value = vehicle.transmission;
        document.getElementById('update_license_plate').value = vehicle.license_plate;
        document.getElementById('update_price_perday').value = vehicle.price_perday; 
    }

    //script to validate input in seat field
    document.getElementById('seats').addEventListener('input', function () {
    if (this.value < 1) {
      this.value = '';
    }
    });

    //script to validate input in price per day field
    document.getElementById('pricePerDay').addEventListener('input',
    function(){
        if(this.value < 1){
            this.value = '';
        }
    });

    //scriipt to validate model input field
  
    document.addEventListener("DOMContentLoaded", function () {
        const modelInput = document.getElementById("model");

        if (modelInput) {
        modelInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^A-Za-z0-9\-]/g, "");
        });
        }
    });

    //scriipt to validate update model input field
     document.addEventListener("DOMContentLoaded", function () {
        const modelInput = document.getElementById("update_model");

        if (modelInput) {
        modelInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^A-Za-z0-9\-]/g, "");
        });
        }
    });

  
    //script to validate input in licence plate field
    document.addEventListener("DOMContentLoaded", function () {
    const licensePlateInput = document.getElementById("licensePlate");

    if (licensePlateInput) {
        licensePlateInput.addEventListener("input", function () {
            
            this.value = this.value.replace(/[^A-Za-z0-9-]/g, "");
        });
    }
    });

    //script to validate input in update licence plate field
    document.addEventListener("DOMContentLoaded", function () {
    const licensePlateInput = document.getElementById("update_license_plate");

    if (licensePlateInput) {
        licensePlateInput.addEventListener("input", function () {
            
            this.value = this.value.replace(/[^A-Za-z0-9-]/g, "");
        });
    }
    });




    document.addEventListener("DOMContentLoaded", function () {
        function setupDateRange(fromId, toId) {
            const fromDateInput = document.getElementById(fromId);
            const toDateInput = document.getElementById(toId);

            if (!fromDateInput || !toDateInput) return;

            toDateInput.disabled = true;

            fromDateInput.addEventListener('change', function () {
                const fromDateValue = fromDateInput.value;
                
                toDateInput.disabled = false;
                toDateInput.setAttribute('min', fromDateValue);

            });
        }

        // Apply to both modals
        setupDateRange('from_date_rented', 'to_date_rented');
        setupDateRange('from_date_available', 'to_date_available');
    });


</script>

<script defer src="../assets/js/bootstrap.bundle.min.js"></script>

<?php include 'components/admin_footer.php'; ?>
 
</body>
</html>
