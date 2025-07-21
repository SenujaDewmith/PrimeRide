<?php
require_once('../../tcpdf/tcpdf.php');
include '../dbconnection.php';

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Rented or Booked Vehicles Report', 0, 1, 'C');

$pdf->Ln(5);

// Vehicles that are involved in active/requested/approved rentals
$from = $_GET['from_date'] ?? null;
$to = $_GET['to_date'] ?? null;

if (!$from || !$to) {
    die('Invalid date range.');
}

$sql = "
SELECT  DISTINCT v.*
FROM vehicles v
JOIN rental r ON r.vehicle_id = v.id
WHERE r.rental_status IN ('requested', 'approved', 'active','Pending Payment')
AND r.pickup_date BETWEEN '$from' AND '$to'
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, $row['vehicle_name'] . ' - ' . $row['model'], 0, 1);
        $pdf->SetFont('helvetica', '', 10);

        $details = "Seats: {$row['seats']} | Fuel: {$row['fuel_type']} | Transmission: {$row['transmission']}\n";
        $details .= "License Plate: {$row['license_plate']} | Price/Day: LKR " . number_format($row['price_perday'], 2);
        $pdf->MultiCell(120, 10, $details, 0, 'L', false, 1);

        $imgPath = '../../../assets/Photo/Vehicleimg/' . $row['image_path'];
        if (file_exists($imgPath)) {
            $pdf->Image($imgPath, 140, $pdf->GetY() - 20, 50, 30, '', '', '', true);
        }

        $pdf->Ln(10);
    }
} else {
    $pdf->Cell(0, 10, 'No rented or booked vehicles found.', 0, 1);
}

$conn->close();
$pdf->Output('Rented_Vehicles_Report.pdf', 'I');
