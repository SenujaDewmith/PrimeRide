<?php include 'assets/php/dbconnection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Special Offers</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- Navigation Bar -->
  <?php include 'navigation.php'; ?>

  <!-- Image Drawer Section for Prime Ride Car Rental -->
  <hr class="featurette-divider">
  <div class="drawer container drawersize"></div>
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/Photo/Drawer/Offer1.png" class="d-block w-100" alt="SUV">
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/rental1.jpg" class="d-block w-100" alt="Sedan">
        <div class="carousel-caption d-none d-md-block">
          <h5>Sedan Rentals</h5>
          <p>Sleek and smooth sedans for business trips or comfortable city travel.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/rental2.jpg" class="d-block w-100" alt="Luxury Cars">
        <div class="carousel-caption d-none d-md-block">
          <h5>Luxury Cars</h5>
          <p>Experience premium luxury for special occasions or high-end travel needs.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/rental3.jpg" class="d-block w-100" alt="Hatchback">
        <div class="carousel-caption d-none d-md-block">
          <h5>Hatchback Rentals</h5>
          <p>Compact and fuel-efficient hatchbacks, ideal for navigating the city streets.</p>
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

  <!-- Special Offers Section Starts -->
  <section class="special-offers py-5" id="special-offers">
    <div class="container">
      <h1 class="text-center mb-5"><span>Special Offers</span></h1>
      <div class="row">
        <?php
        $sql = "SELECT title, description, price, original_price, image_path FROM offers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <!-- Offer Card -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <img src="assets/Photo/Offerimg/<?php echo $row['image_path']; ?>" class="card-img-top"
                  alt="<?php echo $row['title']; ?>">
                <div class="card-body text-center">
                  <h3 class="card-title"><?php echo $row['title']; ?></h3>
                  <p class="card-text"><?php echo $row['description']; ?></p>
                  <h4 class="text-success">LKR<?php echo number_format($row['price'], 2); ?>
                    <span class="text-muted"><del>LKR<?php echo number_format($row['original_price'], 2); ?></del></span>
                  </h4>
                  <a href="#" class="btn btn-primary mt-3 order-now-button"
                     data-offer-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>"
                     data-offer-price="<?php echo htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8'); ?>"
                     data-offer-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?>">
                     Order Now
                  </a>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "No promotions on going now.";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </section>

  <!-- Order Modal -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Order Special Offer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Order Request Form -->
          <form action="assets/php/UserFunctions/Offer_submit.php" method="POST">
            <input type="hidden" name="offer_title" id="modalOfferTitle">
            <input type="hidden" name="offer_price" id="modalOfferPrice">
            <input type="hidden" name="offer_description" id="modalOfferDescription">

            <div class="mb-3">
              <label for="customer_username" class="form-label">Username</label>
              <input type="text" class="form-control" name="customer_username" id="customer_username" 
                     value="<?php echo isset($user_data) ? htmlspecialchars($user_data['username']) : ''; ?>" 
                     <?php echo isset($user_data) ? 'readonly' : ''; ?>>
            </div>

            <div class="mb-3">
              <label for="customer_email" class="form-label">Email</label>
              <input type="email" class="form-control" name="customer_email" id="customer_email" 
                     value="<?php echo isset($user_data) ? htmlspecialchars($user_data['email']) : ''; ?>" 
                     <?php echo isset($user_data) ? 'readonly' : ''; ?> required>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit Order Request</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script src="assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="assets/js/blockinspect.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const orderButtons = document.querySelectorAll('.order-now-button');
      orderButtons.forEach(button => {
        button.addEventListener('click', function () {
          const offerTitle = button.getAttribute('data-offer-title');
          const offerPrice = button.getAttribute('data-offer-price');
          const offerDescription = button.getAttribute('data-offer-description');

          document.getElementById('modalOfferTitle').value = offerTitle;
          document.getElementById('modalOfferPrice').value = offerPrice;
          document.getElementById('modalOfferDescription').value = offerDescription;

          // Show the order modal
          const orderModal = new bootstrap.Modal(document.getElementById('orderModal'), {
            backdrop: 'static',
            keyboard: false
          });
          orderModal.show();
        });
      });
    });
  </script>

</body>

</html>
