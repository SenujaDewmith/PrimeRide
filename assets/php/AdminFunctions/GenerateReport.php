<?php
require_once('../../tcpdf/tcpdf.php'); // ✅ path to your tcpdf folder
 // Or use require path to tcpdf.php
include '../dbconnection.php';

$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];

// Query bookings within range
$sql = "SELECT r.id, c.name AS customer, v.license_plate, r.pickup_date, r.dropoff_date, r.rental_status
        FROM rental r
        JOIN clients c ON r.client_id = c.id
        JOIN vehicles v ON r.vehicle_id = v.id
        WHERE r.pickup_date BETWEEN ? AND ?
        ORDER BY r.pickup_date ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// Start TCPDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Booking Report from $startDate to $endDate", 0, 1, 'C');
$pdf->Ln(5);

// Table Header
$html = '<table border="1" cellpadding="5">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Vehicle Number plate</th>
                <th>Pickup</th>
                <th>Dropoff</th>
                <th>Status</th>
              </tr>
            </thead><tbody>';

// Rows
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['id']}</td>
                <td>{$row['customer']}</td>
                <td>{$row['license_plate']}</td>
                <td>{$row['pickup_date']}</td>
                <td>{$row['dropoff_date']}</td>
                <td>{$row['rental_status']}</td>
              </tr>";
}
$html .= "</tbody></table>";

$pdf->writeHTML($html);
$pdf->Output('booking_report.pdf', 'I'); // I = inline browser preview
?>
