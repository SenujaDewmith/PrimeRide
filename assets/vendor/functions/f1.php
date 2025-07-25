<form method="GET" class="mb-4 text-center">
  <select name="type" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
    <option value="">All Vehicle Types</option>
    <option value="Car" <?php if(isset($_GET['type']) && $_GET['type'] == 'Car') echo 'selected'; ?>>Car</option>
    <option value="Van" <?php if(isset($_GET['type']) && $_GET['type'] == 'Van') echo 'selected'; ?>>Van</option>
    <option value="SUV" <?php if(isset($_GET['type']) && $_GET['type'] == 'SUV') echo 'selected'; ?>>SUV</option>
    <option value="Mini-Van" <?php if(isset($_GET['type']) && $_GET['type'] == 'Mini-Van') echo 'selected'; ?>>Mini-Van</option>
  </select>
</form>

<!-- SQL -->
 <?php
 $typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

if (!empty($typeFilter)) {
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE vehicle_type = ?");
    $stmt->bind_param("s", $typeFilter);
} else {
    $stmt = $conn->prepare("SELECT * FROM vehicles");
}

$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
  // show each vehicle card
}

?>
