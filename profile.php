<?php
session_start();
include 'assets/php/dbconnection.php'; 

if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    header('Location: authentication.php');
    exit();
}

$email = $_SESSION['email'] ?? $_COOKIE['email'];
if (!$email) {
    echo "No email found in session or cookies.";
    exit();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, name, profile_picture FROM clients WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$client_id = $user['id'];
$name = $user['name'];
$profile_picture = !empty($user['profile_picture']) ? $user['profile_picture'] : 'default.jpg';

$hour = date('H');
if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 18) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link href="assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    

    <style>
        body { margin-top: 80px; }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .cprofile { 
            min-height: 500px;
            margin-top: 100px; }
    </style>
</head>
<body>
<header class="p-3 text-bg-brown header">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="assets/Photo/logo.png" class="navlogo" alt="">
                </a>
                <h1>PrimeRide</h1>
            </div>
            <div class="greeting">
                <h3 class="text-white"><?php echo $greeting . ', ' . htmlspecialchars($name); ?>!</h3>
            </div>
            <div>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                Logout
                </button>
            </div>
        </div>
    </div>
</header>
<hr class="featurette-divider">
<div class="submenudirect-wrapper">
    <div class="container submenudirect">
        <header class="d-flex justify-content-py-5">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>        
                <li class="nav-item"><a href="rent-car.php" class="nav-link">Select A Vehicle</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link">FAQ</a></li>
                <li class="nav-item"><a href="Aboutus.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="Contactus.php" class="nav-link">Contact Us</a></li>
            </ul>
        </header>
    </div>
</div>

<div class="cprofile">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center">
                    <img src="assets/database/user-profiles-pic/<?php echo htmlspecialchars($profile_picture); ?>" class="profile-picture mb-3" alt="Profile Picture">
                    <form action="assets/php/UserFunctions/update_profile_picture.php" method="POST" enctype="multipart/form-data">
                        <label for="profilePicUpload" class="form-label">Update Profile Picture</label>
                        <input class="form-control" type="file" id="profilePicUpload" name="profilePicUpload" accept="image/*" required>
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <h3>Customer Profile</h3>

            <!-- Change Password Button -->
            <button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                Change Password
            </button>

                <hr>
                <?php
                $sql = "SELECT id, pickup_date, rental_status, rental_duration, total_price FROM rental WHERE client_id = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("i", $client_id);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>
                <div class="content">
                    <h4>Placed Rentals</h4>
                    <div class="row">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($rental = $result->fetch_assoc()) {
                                echo '<div class="col-md-4">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title">Rental ID: #' . $rental['id'] . '</h5>
                                                <p class="card-text"><strong>Pickup Date:</strong> ' . $rental['pickup_date'] . '</p>
                                                <p class="card-text"><strong>Status:</strong> ' . $rental['rental_status'] . '</p>
                                                <p class="card-text"><strong>Rental Duration (days):</strong> ' . $rental['rental_duration'] . '</p>
                                                <p class="card-text"><strong>Rental Price (LKR):</strong> ' . $rental['total_price'] . '</p>
                                                <button class="btn btn-danger delete-btn" data-rentalid="' . $rental['id'] . '">Delete Rental</button>
                                                <button class="btn btn-info mt-2 update-btn" data-rentalid="' . $rental['id'] . '" data-toggle="modal" data-target="paymentModal">Update Payment</button>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        } else {
                            echo "<p>No rentals found.</p>";
                        }
                        $stmt->close();
                        $conn->close();
                        ?>
                    </div>
                </div>

                <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="changePasswordForm" action="assets/php/UserFunctions/update-password.php" method="POST">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Enter current password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                        <div id="passwordMatchMessage" class="form-text text-danger mt-1"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="submitBtn" disabled>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

       

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this rental?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
                    </div>
                    </div>
                </div>
                </div>


                <!-- Payment Modal -->
                <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel">Upload Payment Receipt</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="assets/php/UserFunctions/Upload_reciept.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="rental_id" name="rental_id">
                                    <div class="form-group">
                                        <label for="receipt">Select Payment Receipt (Photo format only):</label>
                                        <input type="file" class="form-control-file" id="receipt" name="receipt" accept="image/*" required>
                                    </div>
                                    <small class="text-muted">Please upload your payment receipt in photo format (JPEG, PNG).</small>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit Receipt</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout Confirmation Modal -->
                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <a href="assets/php/UserFunctions/logout.php" class="btn btn-danger">Yes, Logout</a>
                    </div>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

// Real-time password match check
        document.addEventListener("DOMContentLoaded", function () {
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirmPassword");
            const message = document.getElementById("passwordMatchMessage");
            const submitBtn = document.getElementById("submitBtn");

            function checkPasswords() {
                if (confirmPassword.value === "") {
                    message.textContent = "";
                    submitBtn.disabled = true;
                    return;
                }

                if (password.value === confirmPassword.value) {
                    message.textContent = "Passwords match";
                    message.classList.remove("text-danger");
                    message.classList.add("text-success");
                    submitBtn.disabled = false;
                } else {
                    message.textContent = "Passwords do not match";
                    message.classList.remove("text-success");
                    message.classList.add("text-danger");
                    submitBtn.disabled = true;
                }
            }

            password.addEventListener("input", checkPasswords);
            confirmPassword.addEventListener("input", checkPasswords);
        });
            
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function() {
                const rentalId = this.getAttribute('data-rentalid');
                document.getElementById('rental_id').value = rentalId;

                const modalEl = document.getElementById('paymentModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const rentalId = this.getAttribute('data-rentalid');
                const confirmBtn = document.getElementById('confirmDeleteBtn');
                confirmBtn.href = `assets/php/UserFunctions/Delete_rental.php?rental_id=${rentalId}`;
                
                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            });
        });

</script>

<?php include 'footer.php'; ?>

<script defer src="assets/js/bootstrap.bundle.min.js"></script>
        
</body>
</html>
