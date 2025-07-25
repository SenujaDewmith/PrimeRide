<?php
include 'assets/php/dbconnection.php';
session_start();

$user_data = null;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $sql = "SELECT name, email FROM clients WHERE email = ?";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user_data = mysqli_fetch_assoc($result);
        } else {
            echo "<script>console.log('No Userdata');</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>console.log('SQL statement error');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script defer src="assets/js/bootstrap.bundle.min.js"></script>
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
  <?php  include 'navigation.php';?>
  
  <hr>
 
  <!-- Available cars -->
  <div class="container mt-5">
      <h2 class="text-center mb-4">Available Vehicles</h2>
      <div class="row">
        <hr>
        <!-- added code here -->
        
        <!-- to here -->
         
        <?php

        // Fetch all available vehicles from the database

        $sql = "SELECT id, vehicle_name, vehicle_make, model, vehicle_type, seats, fuel_type, 
        transmission, image_path, price_perday, license_plate FROM vehicles";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $vehicleName = $row['vehicle_make']." ". $row['model'];
        ?>

                <!-- Car Card -->
                <div class="col-md-4">
                    <div class="card car-card mb-4">
                        <img src="assets/Photo/Vehicleimg/<?php echo $row['image_path']; ?>" class="card-img-top"
                          alt="<?php echo $vehicleName; ?>">
                          <div class="card-body">
                            <h5 class="card-title"><?php echo $vehicleName; ?></h5>
                            <ul class="list-unstyled">
                                <li><strong>Type:</strong> <?php echo $row['vehicle_type'];?></li>
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
            <input type="hidden" name="id" id="id">
           
            <div class="mb-3">
              <h5 class="text-primary" id="selectedVehicleTitle"></h5>
            </div>


            <!-- Auto-fills the user's email from session data -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" name="email" id="email" 
                    value="<?php echo isset($user_data) ? htmlspecialchars($user_data['email']) : ''; ?>" 
                    <?php echo isset($user_data) ? 'readonly' : ''; ?>>
            </div>

            <!-- Auto-fills the user's name from session data -->
            <div class="mb-3">
              <label for="customer_name" class="form-label">Name</label>
              <input type="text" class="form-control" name="customer_name" id="customer_name" 
                    value="<?php echo isset($user_data) ? htmlspecialchars($user_data['name']) : ''; ?>" 
                    <?php echo isset($user_data) ? 'readonly' : ''; ?>>
            </div>


            <div class="mb-3">
              <label for="contact_number" class="form-label">Contact Number</label>
              <input type="tel" class="form-control" name="contact_number" id="contact_number" 
                    maxlength="10" pattern="\d{10}" 
                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" 
                    required>
              <div class="form-text">Enter a 10-digit phone number (numbers only).</div>
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
              <label for="rental_duration" class="form-label">Rental Duration (days)</label>
              <input type="number" class="form-control" name="rental_duration" readonly>
            </div>

            <div class="mb-3">
              <label for="total_price" class="form-label">Total Price (LKR)</label>
              <input type="text" class="form-control" name="total_price" id="totalPrice" readonly>
            </div>

            <div class="mb-3 p-3 bg-light border rounded">
              <h6 class="fw-bold">Advance Payment Instructions</h6>
              <p class="mb-1">Please make an advance payment of <strong>50% of the total rental amount</strong> to the bank account below:</p>
              <ul class="mb-2">
                <li><strong>Bank Name:</strong> People's Bank</li>
                <li><strong>Account Name:</strong> Prime Ride Rent Car</li>
                <li><strong>Account Number:</strong> 1234567890</li>
                <li><strong>Branch:</strong> Katugasthota Branch</li>
              </ul>
              <p class="mb-0">
                After completing the transfer, please upload the payment slip under the <strong>"Upload Payment Receipt"</strong> section in <strong>My Account</strong>.
              </p>
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
              document.getElementById('selectedVehicleTitle').innerText = `${vehicleName} (${model})`;
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
              pricePerDay = parseFloat(button.getAttribute('data-price-per-day')); //Uses parseFloat() to convert that string to a number 

              
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
 

      dropoffDateInput.disabled = true; //Initially disables the drop-off date field.

      const today = new Date().toISOString().split('T')[0];
      pickupDateInput.setAttribute('min', today);

    
      pickupDateInput.addEventListener('change', function () {
          const pickupDateValue = pickupDateInput.value;

          // Additional security for choosing past date
          if (new Date(pickupDateValue) < new Date(today)) {
              alert("Pickup date cannot be in the past.");
              pickupDateInput.value = "";
              return;
          }

          dropoffDateInput.disabled = false;
          dropoffDateInput.setAttribute('min', pickupDateValue);

          //Clearinf previous values
          dropoffDateInput.value = "";
          rentalDurationInput.value = "";
          totalPriceInput.value = "";
      });

      //checks drop off date equal or greater that pickup date
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
                        
                      backdrop: 'static', //restric clicking outside 
                      keyboard: false //restric pressing Escape
                      
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




  <?php include 'footer.php'; ?>


  <script>
    function setModalData(vehicleName, model) {
      document.getElementById('modalVehicleName').value = vehicleName;
      document.getElementById('modalModel').value = model;
    }
  </script>

  <script>
  let unavailableDates = [];

  function fetchUnavailableDates(plateNumber) {
    fetch(`assets/php/userFunctions/get_unavailable_dates.php?plate_number=${encodeURIComponent(plateNumber)}`)
      .then(response => response.json())
      .then(data => {
        unavailableDates = data;
        console.log('Unavailable Dates:', unavailableDates);
      });
  }

  function isDateUnavailable(date) {
    return unavailableDates.some(range => {
      const from = new Date(range.pickup_date);
      const to = new Date(range.dropoff_date);
      date.setHours(0, 0, 0, 0);
      return date >= from && date <= to;
    });
  }

  // Disable unavailable dates
  function disableUnavailableDates(input) {
    input.addEventListener('input', function () {
      const date = new Date(this.value);
      if (isDateUnavailable(date)) {
        alert("This date is not available for this vehicle.");
        this.value = "";
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    const pickupDateInput = document.querySelector('input[name="pickup_date"]');
    const dropoffDateInput = document.querySelector('input[name="dropoff_date"]');

    disableUnavailableDates(pickupDateInput);
    disableUnavailableDates(dropoffDateInput);

    const rentButtons = document.querySelectorAll('.rent-now-button');
    rentButtons.forEach(button => {
      button.addEventListener('click', function () {
        const plateNumber = button.getAttribute('data-plate-number');
        fetchUnavailableDates(plateNumber);
      });
    });
  });
</script>


</body>

</html>
