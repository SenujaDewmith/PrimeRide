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

$client_id = $user['client_id'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin-top: 80px; }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .cprofile { margin-top: 100px; }
    </style>
</head>
<body>
<header class="p-3 text-bg-brown header">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="assets/Photo/logo.png" class="navlogo" alt="">
                </a>
                <h1>PrimeRide</h1>
            </div>
            <div class="greeting">
                <h3 class="text-white"><?php echo $greeting . ', ' . htmlspecialchars($name); ?>!</h3>
            </div>
            <div>
                <a href="assets/php/UserFunctions/logout.php" class="btn btn-danger">Logout</a>
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
                <li class="nav-item"><a href="Specialoffers.php" class="nav-link">Offers</a></li>
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
                <form action="assets/php/UserFunctions/update-password.php" method="POST">
                    <div class="mb-3">
                        <label for="password" class="form-label">Change Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
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
                                                <button class="btn btn-info mt-2 update-btn" data-rentalid="' . $rental['id'] . '" data-toggle="modal" data-target="#paymentModal">Update Payment</button>
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
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.update-btn').forEach(button => {
    button.addEventListener('click', function() {
        const rentalId = this.getAttribute('data-rentalid');
        document.getElementById('rental_id').value = rentalId;
    });
});
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const rentalId = this.getAttribute('data-rentalid');
        if (confirm('Are you sure you want to delete this rental?')) {
            window.location.href = `assets/php/UserFunctions/Delete_rental.php?rental_id=${rentalId}`;
        }
    });
});
</script>
</body>
</html>
