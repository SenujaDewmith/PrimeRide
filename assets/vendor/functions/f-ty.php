        <!-- added code here -->
<form method="GET" class="mb-4 text-center">
  <select name="type" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
    <option value="">All Vehicle Types</option>
    <option value="Car" <?php if(isset($_GET['type']) && $_GET['type'] == 'Car') echo 'selected'; ?>>Car</option>
    <option value="Van" <?php if(isset($_GET['type']) && $_GET['type'] == 'Van') echo 'selected'; ?>>Van</option>
    <option value="Suv" <?php if(isset($_GET['type']) && $_GET['type'] == 'SUV') echo 'selected'; ?>>SUV</option>
    <option value="Mini-Van" <?php if(isset($_GET['type']) && $_GET['type'] == 'Mini-Van') echo 'selected'; ?>>Mini-Van</option>
  </select>
</form>

<!-- SQL -->
 <?php
 $typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

if (!empty($typeFilter)) {
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE vehicle_type = ?");
    $stmt->bind_param("s", $typeFilter);


$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
  $vehicleName = $row['vehicle_make']." ". $row['model'];
?>
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
        
        <!-- to here -->


<!-- Most rented  start-->
 <button class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#mostRentedModal">
  <strong>Most Rented Vehicle Report</strong>
</button>
<!-- Date Range Modal for Most Rented Vehicles -->
<div class="modal fade" id="mostRentedModal" tabindex="-1" aria-labelledby="mostRentedModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="../assets/php/AdminFunctions/MostRented.php" target="_blank" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mostRentedModalLabel">Select Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="from_date_most" class="form-label">From Date</label>
          <input type="date" id="from_date_most" name="from_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="to_date_most" class="form-label">To Date</label>
          <input type="date" id="to_date_most" name="to_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate Report</button>
      </div>
    </form>
  </div>
</div>


<script>setupDateRange('from_date_most', 'to_date_most');</script>

<!-- mostrented.php -->
<?php
require_once('../../tcpdf/tcpdf.php');
include '../dbconnection.php';

// Get date range from GET parameters
$from = $_GET['from_date'] ?? null;
$to = $_GET['to_date'] ?? null;

if (!$from || !$to) {
    die('Invalid date range.');
}

// Create new PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Most Rented Vehicles Report', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Date Range: $from to $to", 0, 1, 'C');
$pdf->Ln(5);

// Query to get top rented vehicles in the date range
$sql = "
    SELECT 
        v.vehicle_make,
        v.model,
        v.seats,
        v.fuel_type,
        v.transmission,
        v.license_plate,
        v.price_perday,
        v.image_path,
        COUNT(r.id) AS rental_count
    FROM 
        rental r
    INNER JOIN 
        vehicles v ON r.vehicle_id = v.id
    WHERE 
        r.rental_status IN ('approved', 'completed') AND
        r.pickup_date >= ? AND r.return_date <= ?
    GROUP BY 
        v.id
    ORDER BY 
        rental_count DESC
    LIMIT 5
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, $row['vehicle_make'] . ' ' . $row['model'], 0, 1);
        $pdf->SetFont('helvetica', '', 10);

        $details = "Seats: {$row['seats']} | Fuel: {$row['fuel_type']} | Transmission: {$row['transmission']}\n";
        $details .= "License Plate: {$row['license_plate']} | Price/Day: LKR " . number_format($row['price_perday'], 2) . "\n";
        $details .= "Total Rentals: " . $row['rental_count'];
        $pdf->MultiCell(120, 10, $details, 0, 'L', false, 1);

        $imgPath = '../../../assets/Photo/Vehicleimg/' . $row['image_path'];
        if (file_exists($imgPath)) {
            $pdf->Image($imgPath, 140, $pdf->GetY() - 20, 50, 30, '', '', '', true);
        }

        $pdf->Ln(10);
    }
} else {
    $pdf->Cell(0, 10, 'No rental data available for the selected period.', 0, 1);
}

$conn->close();
$pdf->Output('Most_Rented_Vehicles_Report.pdf', 'I');
?>


<!-- End of MR -->



<!-- Most rent U start -->
 <button class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#mostRentingUserModal">
  <strong>Top Renting User Report</strong>
</button>
<!-- Date Range Modal -->
<div class="modal fade" id="mostRentingUserModal" tabindex="-1" aria-labelledby="mostRentingUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="../assets/php/AdminFunctions/MostRentingUser.php" target="_blank" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mostRentingUserModalLabel">Select Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="from_date_user" class="form-label">From Date</label>
          <input type="date" id="from_date_user" name="from_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="to_date_user" class="form-label">To Date</label>
          <input type="date" id="to_date_user" name="to_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate Report</button>
      </div>
    </form>
  </div>
</div>

<script>setupDateRange('from_date_user', 'to_date_user');
</script>

<!-- mostrentinguser.php -->
 <?php
require_once('../../tcpdf/tcpdf.php');
include '../dbconnection.php';

$from = $_GET['from_date'] ?? null;
$to = $_GET['to_date'] ?? null;

if (!$from || !$to) {
    die('Invalid date range.');
}

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Top Renting User Report', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Date Range: $from to $to", 0, 1, 'C');
$pdf->Ln(5);

// Query: Get the user with most rentals
$sql = "
    SELECT 
        c.name,
        c.email,
        COUNT(r.id) AS total_rentals
    FROM 
        rental r
    INNER JOIN 
        clients c ON r.client_id = c.id
    WHERE 
        r.rental_status IN ('approved', 'completed') AND
        r.pickup_date >= ? AND r.return_date <= ?
    GROUP BY 
        r.client_id
    ORDER BY 
        total_rentals DESC
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Top Renting User:', 0, 1);

    $pdf->SetFont('helvetica', '', 11);
    $pdf->Cell(0, 10, "Name: " . $row['name'], 0, 1);
    $pdf->Cell(0, 10, "Email: " . $row['email'], 0, 1);
    $pdf->Cell(0, 10, "Total Rentals: " . $row['total_rentals'], 0, 1);
} else {
    $pdf->Cell(0, 10, 'No rental records found for this date range.', 0, 1);
}

$conn->close();
$pdf->Output('Top_Renting_User_Report.pdf', 'I');
?>

<!-- mostrentU end -->

<!-- least Vehicle -->
 <button class="btn btn-dark ms-2" data-bs-toggle="modal" data-bs-target="#leastRentedModal">
  <strong>Least Rented Vehicle Report</strong>
</button>

<div class="modal fade" id="leastRentedModal" tabindex="-1" aria-labelledby="leastRentedModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="../assets/php/AdminFunctions/LeastRented.php" target="_blank" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leastRentedModalLabel">Select Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="from_date_least" class="form-label">From Date</label>
          <input type="date" id="from_date_least" name="from_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="to_date_least" class="form-label">To Date</label>
          <input type="date" id="to_date_least" name="to_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate Report</button>
      </div>
    </form>
  </div>
</div>
<script>setupDateRange('from_date_least', 'to_date_least');
</script>

<!-- leastrent.php -->
<?php
require_once('../../tcpdf/tcpdf.php');
include '../dbconnection.php';

$from = $_GET['from_date'] ?? null;
$to = $_GET['to_date'] ?? null;

if (!$from || !$to) {
    die('Invalid date range.');
}

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Least Rented Vehicles Report', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Date Range: $from to $to", 0, 1, 'C');
$pdf->Ln(5);

// Query: Least rented vehicles in given range
$sql = "
    SELECT 
        v.vehicle_make,
        v.model,
        v.seats,
        v.fuel_type,
        v.transmission,
        v.license_plate,
        v.price_perday,
        v.image_path,
        COUNT(r.id) AS rental_count
    FROM 
        vehicles v
    LEFT JOIN 
        rental r ON r.vehicle_id = v.id 
        AND r.rental_status IN ('approved', 'completed') 
        AND r.pickup_date >= ? AND r.return_date <= ?
    GROUP BY 
        v.id
    ORDER BY 
        rental_count ASC
    LIMIT 5
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, $row['vehicle_make'] . ' ' . $row['model'], 0, 1);
        $pdf->SetFont('helvetica', '', 10);

        $details = "Seats: {$row['seats']} | Fuel: {$row['fuel_type']} | Transmission: {$row['transmission']}\n";
        $details .= "License Plate: {$row['license_plate']} | Price/Day: LKR " . number_format($row['price_perday'], 2) . "\n";
        $details .= "Total Rentals: " . $row['rental_count'];
        $pdf->MultiCell(120, 10, $details, 0, 'L', false, 1);

        $imgPath = '../../../assets/Photo/Vehicleimg/' . $row['image_path'];
        if (file_exists($imgPath)) {
            $pdf->Image($imgPath, 140, $pdf->GetY() - 20, 50, 30, '', '', '', true);
        }

        $pdf->Ln(10);
    }
} else {
    $pdf->Cell(0, 10, 'No vehicle rental data found in this range.', 0, 1);
}

$conn->close();
$pdf->Output('Least_Rented_Vehicles_Report.pdf', 'I');
?>

<!-- LR end -->


<!-- feedbackrep start -->
 <button class="btn btn-secondary ms-2" data-bs-toggle="modal" data-bs-target="#feedbackReportModal">
  <strong>Staff Feedback Report</strong>
</button>

<div class="modal fade" id="feedbackReportModal" tabindex="-1" aria-labelledby="feedbackReportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="../assets/php/AdminFunctions/FeedbackReport.php" target="_blank" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackReportModalLabel">Select Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="from_date_feedback" class="form-label">From Date</label>
          <input type="date" id="from_date_feedback" name="from_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="to_date_feedback" class="form-label">To Date</label>
          <input type="date" id="to_date_feedback" name="to_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate Report</button>
      </div>
    </form>
  </div>
</div>
<script>setupDateRange('from_date_feedback', 'to_date_feedback');
</script>

<!-- feedbackrepo.php -->
<?php
require_once('../../tcpdf/tcpdf.php');
include '../dbconnection.php';

$from = $_GET['from_date'] ?? null;
$to = $_GET['to_date'] ?? null;

if (!$from || !$to) {
    die('Invalid date range.');
}

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Staff Feedback Report', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Date Range: $from to $to", 0, 1, 'C');
$pdf->Ln(5);

// Query for feedback data
$sql = "
    SELECT id, title, name, email, phone, message, submitted_at 
    FROM staff_feedback 
    WHERE DATE(submitted_at) BETWEEN ? AND ?
    ORDER BY submitted_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, "Feedback ID: " . $row['id'] . " | " . $row['title'], 0, 1);

        $pdf->SetFont('helvetica', '', 10);
        $details  = "Name: {$row['name']}\n";
        $details .= "Email: {$row['email']} | Phone: {$row['phone']}\n";
        $details .= "Date: " . date('Y-m-d', strtotime($row['submitted_at'])) . "\n";
        $details .= "Message:\n" . $row['message'];
        
        $pdf->MultiCell(0, 8, $details, 1, 'L', false, 1);
        $pdf->Ln(5);
    }
} else {
    $pdf->Cell(0, 10, 'No feedback records found in this date range.', 0, 1);
}

$conn->close();
$pdf->Output('Staff_Feedback_Report.pdf', 'I');
?>

<!-- Feedback END -->
