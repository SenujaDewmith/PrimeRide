<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Admin Dashboard</title>
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
    <!-- View Promotions -->

<?php
// Include database connection
include '../assets/php/dbconnection.php';
?>

<div class="content min-vh-100">
    <h2>Offer Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOfferModal">Add New Offer</button>
    <div class="row mt-4">
        <?php
        // Fetch offers from the database
        $sql = "SELECT id, title, description, price, original_price, image_path FROM offers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card offer-card">
                        <img src="../assets/Photo/Offerimg/<?php echo $row['image_path']; ?>" class="card-img-top"
                             alt="<?php echo $row['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p class="card-text text-success">LKR<?php echo number_format($row['price'], 2); ?>
                                <span class="text-muted"><del>LKR<?php echo number_format($row['original_price'], 2); ?></del></span>
                            </p>
                            <form action="../assets/php/AdminFunctions/DeleteOffer.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateOfferModal" 
                                    onclick="populateUpdateModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No offers available.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>

<!-- Add Offer Modal -->
<div class="modal fade" id="addOfferModal" tabindex="-1" aria-labelledby="addOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOfferModalLabel">Add New Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../assets/php/AdminFunctions/AddOffer.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="offerTitle" class="form-label">Offer Title</label>
                        <input type="text" class="form-control" id="offerTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="originalPrice" class="form-label">Original Price</label>
                        <input type="number" step="0.01" class="form-control" id="originalPrice" name="original_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="offerImage" class="form-label">Offer Image</label>
                        <input type="file" class="form-control" id="offerImage" name="image_path" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Offer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Offer Modal -->
<div class="modal fade" id="updateOfferModal" tabindex="-1" aria-labelledby="updateOfferLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateOfferLabel">Update Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../assets/php/AdminFunctions/UpdateOffer.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="updateOfferId" name="id">
                    <div class="mb-3">
                        <label for="updateOfferTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="updateOfferTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfferDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="updateOfferDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfferPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="updateOfferPrice" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfferOriginalPrice" class="form-label">Original Price</label>
                        <input type="number" class="form-control" id="updateOfferOriginalPrice" name="original_price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfferImage" class="form-label">Update Image (optional)</label>
                        <input type="file" class="form-control" id="updateOfferImage" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Offer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to populate the update modal -->
<script>
function populateUpdateModal(offer) {
    document.getElementById('updateOfferId').value = offer.id;
    document.getElementById('updateOfferTitle').value = offer.title;
    document.getElementById('updateOfferDescription').value = offer.description;
    document.getElementById('updateOfferPrice').value = offer.price;
    document.getElementById('updateOfferOriginalPrice').value = offer.original_price;
}
</script>

<?php include 'components/admin_footer.php'; ?>
 
</body>
</html>
