<?php include 'assets/php/dbconnection.php'; session_start();?>



<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->

  <link rel="stylesheet" href="assets/css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PrimeRide | About Us</title>
</head>

<body>

  <!-- Header -->
  <?php include 'navigation.php'; ?>

  <!-- About Us Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <img src="assets/Photo/Drawer/fleet1.jpg" alt="PrimeRide Fleet" class="img-fluid rounded">
        </div>
        <div class="col-md-6">
          <h2 class="display-6">About PrimeRide</h2>
          <p class="lead">
            Welcome to PrimeRide, the leading car rental solution in Sri Lanka. Whether you're exploring the city, planning a road trip, or on a business visit, we provide a fleet of vehicles that suits your every need. From compact cars to luxury sedans, spacious SUVs, and vans, PrimeRide has got you covered.
          </p>
          <p>
            Our mission is to offer a car rental experience that exceeds customer expectations by focusing on convenience, reliability, and personalized service. With a state-of-the-art online booking system, you can effortlessly browse our fleet, compare options, and secure your rental in minutes. No hidden fees—just transparent pricing and an enjoyable journey ahead.
          </p>
          <p>
            At PrimeRide, we prioritize safety and sustainability. Every vehicle in our fleet undergoes strict maintenance, ensuring the highest safety standards. We're also proud to introduce eco-friendly hybrid and electric options for environmentally conscious travelers.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Mission, Vision, and Values -->
  <section class="py-5 text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <i class="bi bi-compass display-4 text-primary"></i>
          <h3 class="mt-3">Our Mission</h3>
          <p>
            To provide a superior car rental experience that combines convenience, safety, and sustainability, while meeting the evolving needs of our customers.
          </p>
        </div>
        <div class="col-md-4">
          <i class="bi bi-lightbulb display-4 text-primary"></i>
          <h3 class="mt-3">Our Vision</h3>
          <p>
            To be the most trusted and preferred car rental service in Sri Lanka, offering innovative and flexible travel solutions that ensure memorable journeys.
          </p>
        </div>
        <div class="col-md-4">
          <i class="bi bi-heart display-4 text-primary"></i>
          <h3 class="mt-3">Our Values</h3>
          <p>
            Customer satisfaction, transparency, and commitment to sustainability are at the heart of everything we do. We strive to provide exceptional service with every rental.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center display-6 mb-4">Gallery</h2>
      <div class="row">
        <?php
        $sql = "SELECT title, image_path FROM gallery";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-md-4 mb-4">
              <div class="card">
                <img src="assets/Photo/galleryimg/<?php echo $row['image_path']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
              </div>
            </div>
            <?php
          }
        } else {
          echo "Gallery Still Upadating";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

<script defer src="assets/js/bootstrap.bundle.min.js"></script>
  
</body>

</html>
