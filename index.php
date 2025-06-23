<!DOCTYPE html>
<html lang="en">

<head>
  
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  -->
  
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script defer src="assets/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="assets/css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Home</title>
</head>

<body>

  <!-- Navigation bar -->
  <?php include 'navigation.php'; ?>

  <!-- Image Drawer -->
  
  <hr class="featurette-divider">

  <div class="drawer container drawersize"></div>
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/Photo/Drawer/homedrawer3.png" class="d-block w-100" alt="">
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/homedrawer2.png" class="d-block w-100" alt="">
      </div>
      <div class="carousel-item">
        <img src="assets/Photo/Drawer/homedrawer1.png" class="d-block w-100" alt="">
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

  <!-- Introduction -->
  <hr class="featurette-divider">
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-6 text-start">
              <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="assets/Photo/Content/home1.jpg">
            </div>
            <div class="col-6 text-start">
              <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="assets/Photo/Content/home2.jpg" style="margin-top: 25%;">
            </div>
            <div class="col-6 text-end">
              <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="assets/Photo/Content/home3.jpg">
            </div>
            <div class="col-6 text-end">
              <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="assets/Photo/Content/home1.jpg">
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <h1 class="mb-4">Welcome to PrimeRide <i class="fa fa-utensils text-primary me-2"></i>Your Ultimate Car Rental Solution in Sri Lanka</h1>
          <p class="mb-4">
            At PrimeRide, we are redefining the car rental experience by combining convenience, reliability, and exceptional service to meet the diverse needs of modern travelers. Whether you're a local resident, a business professional, or an international visitor, PrimeRide offers a seamless, hassle-free car rental solution tailored to your journey.

            Our fleet features a wide range of vehicles, from compact cars perfect for city driving to luxury sedans, spacious SUVs, and off-road vehicles for your Sri Lankan adventures. With flexible rental terms, easy online booking, and transparent pricing, PrimeRide ensures your rental process is smooth and stress-free.

            At the core of our operations is a commitment to customer satisfaction, safety, and sustainability. Each vehicle is meticulously maintained and equipped with advanced safety features, while our growing eco-friendly fleet reflects our dedication to promoting sustainable travel.

            Choose PrimeRide for your next trip and experience a superior level of service, convenience, and care. Let us make your journey across Sri Lanka memorable, safe, and enjoyable.
          </p>

          <div class="row g-4 mb-4">
            <div class="col-sm-6">
              <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up" data-target="15">0</h1>
                <div class="ps-4">
                  <p class="mb-0">Years of</p>
                  <h6 class="text-uppercase mb-0">Experience</h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up" data-target="50">0</h1>
                <div class="ps-4">
                  <p class="mb-0">Popular</p>
                </div>
              </div>
            </div>
          </div>
          <a class="btn btn-primary py-3 px-5 mt-2" href="Aboutus.php">Read More</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Reviews Section -->
  <section class="reviews py-5" id="reviews">
    <div class="container">
      <h1 class="text-center mb-5"><span>Client's Reviews</span></h1>
      <div class="row">
        <!-- Review Cards -->
       
<div class="col-lg-4 col-md-6 mb-4">
  <div class="card h-100 text-center">
    <img src="assets/Photo/Drawer/profile.jpg" class="card-img-top rounded-circle mx-auto mt-3" alt="John Doe" style="width: 150px; height: 150px;">
    <div class="card-body">
      <h3 class="card-title">John Doe</h3>
      <p class="card-text">"The service was amazing! The team was professional, and the process was seamless. I couldn't have asked for more."</p>
      <div class="stars text-warning">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star-half-alt"></i> <!-- 4.5 stars -->
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
  <div class="card h-100 text-center">
    <img src="assets/Photo/Drawer/profile.jpg" class="card-img-top rounded-circle mx-auto mt-3" alt="Jane Smith" style="width: 150px; height: 150px;">
    <div class="card-body">
      <h3 class="card-title">Jane Smith</h3>
      <p class="card-text">"I was thoroughly impressed with the attention to detail. The staff went above and beyond to meet my needs!"</p>
      <div class="stars text-warning">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i> <!-- 5 stars -->
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
  <div class="card h-100 text-center">
    <img src="assets/Photo/Drawer/profile.jpg" class="card-img-top rounded-circle mx-auto mt-3" alt="Emily Johnson" style="width: 150px; height: 150px;">
    <div class="card-body">
      <h3 class="card-title">Emily Johnson</h3>
      <p class="card-text">"Fantastic experience! Everything was handled professionally, and I felt supported throughout the entire process."</p>
      <div class="stars text-warning">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star-half-alt"></i>
        <i class="fas fa-star-half-alt"></i> <!-- 4 stars -->
      </div>
    </div>
  </div>
</div>

      
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script src="assets/js/script.js"></script>

  <!-- <script src="assets/js/blockinspect.js"></script>  -->

</body>

</html>
