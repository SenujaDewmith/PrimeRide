<?php
include 'assets/php/dbconnection.php';
session_start();

$user_data = null;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    echo "<script>console.log('Session username: " . $username . "');</script>";

    $sql = "SELECT username, name, email FROM clients WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
        } else {
            echo "<script>console.log('No Userdata');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>console.log('SQL statement error');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Rent Car</title>

  <style>
    body{
      margin-top:60px;
    }
    .car-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .car-card {
      transition: box-shadow 0.3s ease;
    }

    .car-card:hover {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>

  <!-- Navigation Bar -->
  <?php include 'navigation.php'; ?>
  <hr>
  <!-- Available cars -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Available Vehicles</h2>
    <div class="row">
      <hr>

      <?php
      // Fetch all available vehicles from the database
      $sql = "SELECT vehicle_name, model, seats, fuel_type, transmission, image_path, price_perday, license_plate FROM vehicles";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              ?>
              <!-- Car Card -->
              <div class="col-md-4">
                  <div class="card car-card mb-4">
                      <img src="assets/Photo/Vehicleimg/<?php echo $row['image_path']; ?>" class="card-img-top"
                        alt="<?php echo $row['vehicle_name']; ?>">
                      <div class="card-body">
                          <h5 class="card-title"><?php echo $row['vehicle_name']; ?></h5>
                          <p class="card-text"><?php echo $row['model']; ?> - Spacious and comfortable. Perfect for family trips.</p>
                          <ul class="list-unstyled">
                              <li><strong>Seats:</strong> <?php echo $row['seats']; ?></li>
                              <li><strong>Fuel Type:</strong> <?php echo $row['fuel_type']; ?></li>
                              <li><strong>Transmission:</strong> <?php echo $row['transmission']; ?></li>
                              <li><strong>Price per Day:</strong> LKR <?php echo number_format($row['price_perday'], 2); ?></li> 
                          </ul>
                          <a href="#" class="btn btn-primary rent-now-button"
                             data-vehicle-name="<?php echo htmlspecialchars($row['vehicle_name'], ENT_QUOTES, 'UTF-8'); ?>"
                             data-model="<?php echo htmlspecialchars($row['model'], ENT_QUOTES, 'UTF-8'); ?>"
                             data-plate-number="<?php echo htmlspecialchars($row['license_plate'], ENT_QUOTES, 'UTF-8'); ?>"
                             data-price-per-day="<?php echo htmlspecialchars($row['price_perday'], ENT_QUOTES, 'UTF-8'); ?>">
                             Rent Now
                          </a>
                      </div>
                  </div>
              </div>
              <?php
          }
      } else {
          echo "No vehicles available for rent";
      }

      $conn->close();
      ?>
    </div>
</div>

<!-- Rent Modal -->
<div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rentModalLabel">Rent Vehicle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Rent Request Form -->
        <form action="assets/php/userFunctions/submit_rent.php" method="POST">
          <input type="hidden" name="vehicle_name" id="modalVehicleName">
          <input type="hidden" name="model" id="modalModel">
          <input type="hidden" name="plate_number" id="modalPlateNumber">

          <div class="mb-3">
            <label for="customer_username" class="form-label">Username</label>
            <input type="text" class="form-control" name="customer_username" id="customer_username" 
                   value="<?php echo isset($user_data) ? htmlspecialchars($user_data['username']) : ''; ?>" 
                   <?php echo isset($user_data) ? 'readonly' : ''; ?>>
          </div>

          <div class="mb-3">
            <label for="customer_name" class="form-label">Name</label>
            <input type="text" class="form-control" name="customer_name" id="customer_name" 
                   value="<?php echo isset($user_data) ? htmlspecialchars($user_data['name']) : ''; ?>" 
                   <?php echo isset($user_data) ? 'readonly' : ''; ?>>
          </div>

          <div class="mb-3">
            <label for="customer_email" class="form-label">Email</label>
            <input type="email" class="form-control" name="customer_email" id="customer_email" 
                   value="<?php echo isset($user_data) ? htmlspecialchars($user_data['email']) : ''; ?>" 
                   <?php echo isset($user_data) ? 'readonly' : ''; ?> required>
          </div>

          <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="tel" class="form-control" name="contact_number" required>
          </div>

          <div class="mb-3">
            <label for="rental_duration" class="form-label">Rental Duration (days)</label>
            <input type="number" class="form-control" name="rental_duration" readonly>
          </div>

          <div class="mb-3">
            <label for="pickup_date" class="form-label">Pickup Date</label>
            <input type="date" class="form-control" name="pickup_date" required>
          </div>

          <div class="mb-3">
            <label for="dropoff_date" class="form-label">Drop-off Date</label>
            <input type="date" class="form-control" name="dropoff_date" required>
          </div>

          <div class="mb-3">
            <label for="total_price" class="form-label">Total Price (LKR)</label>
            <input type="text" class="form-control" name="total_price" id="totalPrice" readonly>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit Rent Request</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Login Prompt Modal -->
<div class="modal fade" id="loginPromptModal" tabindex="-1" aria-labelledby="loginPromptModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginPromptModalLabel">Login Required</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Please log in to your account to book a vehicle.</p>
      </div>
      <div class="modal-footer">
        <a href="authentication.php" class="btn btn-primary">Log In</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
  //Hidden values passing script
document.addEventListener('DOMContentLoaded', function () {
    const rentButtons = document.querySelectorAll('.rent-now-button');
    rentButtons.forEach(button => {
        button.addEventListener('click', function () {
            const vehicleName = button.getAttribute('data-vehicle-name');
            const model = button.getAttribute('data-model');
            const plateNumber = button.getAttribute('data-plate-number');

            console.log('Vehicle Name:', vehicleName);
            console.log('Model:', model);
            console.log('Plate Number:', plateNumber);

            document.getElementById('modalVehicleName').value = vehicleName;
            document.getElementById('modalModel').value = model;
            document.getElementById('modalPlateNumber').value = plateNumber;
        });
    });
});

</script>


<script>
  //Calender dates selection logic and price calcultion script
document.addEventListener('DOMContentLoaded', function () {
    const rentalDurationInput = document.querySelector('input[name="rental_duration"]');
    const pickupDateInput = document.querySelector('input[name="pickup_date"]');
    const dropoffDateInput = document.querySelector('input[name="dropoff_date"]');
    const totalPriceInput = document.querySelector('#totalPrice');

    let pricePerDay = 0;

    const rentButtons = document.querySelectorAll('.rent-now-button');
    rentButtons.forEach(button => {
        button.addEventListener('click', function () {
            const vehicleName = button.getAttribute('data-vehicle-name');
            const model = button.getAttribute('data-model');
            const plateNumber = button.getAttribute('data-plate-number');
            pricePerDay = parseFloat(button.getAttribute('data-price-per-day'));

            console.log('Vehicle Name:', vehicleName);
            console.log('Model:', model);
            console.log('Plate Number:', plateNumber);
            console.log('Price Per Day:', pricePerDay);

            document.getElementById('modalVehicleName').value = vehicleName;
            document.getElementById('modalModel').value = model;
            document.getElementById('modalPlateNumber').value = plateNumber;

            totalPriceInput.value = ""; 
        });
    });

    
    dropoffDateInput.disabled = true;

    
    const today = new Date().toISOString().split('T')[0];
    pickupDateInput.setAttribute('min', today);

   
    pickupDateInput.addEventListener('change', function () {
        const pickupDateValue = pickupDateInput.value;

        
        if (new Date(pickupDateValue) < new Date(today)) {
            alert("Pickup date cannot be in the past.");
            pickupDateInput.value = "";
            return;
        }

        
        dropoffDateInput.disabled = false;
        dropoffDateInput.setAttribute('min', pickupDateValue);

        
        dropoffDateInput.value = "";
        rentalDurationInput.value = "";
        totalPriceInput.value = "";
    });

   
    dropoffDateInput.addEventListener('change', function () {
        const pickupDateValue = pickupDateInput.value;
        const dropoffDateValue = dropoffDateInput.value;

        
        if (new Date(dropoffDateValue) <= new Date(pickupDateValue)) {
            alert("Drop-off date must be after the pickup date.");
            dropoffDateInput.value = "";
            return;
        }

       
        const pickupDate = new Date(pickupDateValue);
        const dropoffDate = new Date(dropoffDateValue);
        const duration = Math.ceil((dropoffDate - pickupDate) / (1000 * 60 * 60 * 24));
        
       
        rentalDurationInput.value = duration;

        
        if (pricePerDay > 0) {
            const totalPrice = duration * pricePerDay;
            totalPriceInput.value = totalPrice.toFixed(2);
        }
    });
});

</script>


<script>
  //user login alert box script
document.addEventListener('DOMContentLoaded', function () {
    let isLoggedIn = <?php echo isset($user_data) ? 'true' : 'false'; ?>;

    const rentButtons = document.querySelectorAll('.rent-now-button');
    rentButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); 

            if (!isLoggedIn) {
                
                const loginPromptModal = new bootstrap.Modal(document.getElementById('loginPromptModal'), {
                    backdrop: 'static', 
                    keyboard: false 
                });
                loginPromptModal.show();
            } else {
                
                const vehicleName = button.getAttribute('data-vehicle-name');
                const model = button.getAttribute('data-model');
                const plateNumber = button.getAttribute('data-plate-number');
                const pricePerDay = parseFloat(button.getAttribute('data-price-per-day'));

                document.getElementById('modalVehicleName').value = vehicleName;
                document.getElementById('modalModel').value = model;
                document.getElementById('modalPlateNumber').value = plateNumber;

                
                document.getElementById('totalPrice').value = ""; 

                const rentModal = new bootstrap.Modal(document.getElementById('rentModal'), {
                    backdrop: 'static', 
                    keyboard: false  
                });
                rentModal.show();
            }
        });
    });
});
</script>

 <!--Drawer -->
 <div class="drawer container drawersize"></div>
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/Photo/Drawer/rental1.jpg" class="d-block w-100" alt="">
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/rental2.jpg" class="d-block w-100" alt="">
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/rentcar3.png" class="d-block w-100" alt="">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script src="assets/js/blockinspect.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    function setModalData(vehicleName, model) {
      document.getElementById('modalVehicleName').value = vehicleName;
      document.getElementById('modalModel').value = model;
    }
  </script>

</body>

</html>
