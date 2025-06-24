<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script defer src="assets/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <title>PrimeRide | Contact Us</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin-top: 200px;
      /* margin-bottom: 200px; */
    }

    .form-section {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
      margin-top: 20px;
    }

    .submit-btn {
      background-color: #ff5722;
      color: white;
    }

    .submit-btn:hover {
      background-color: #e64a19;
    }
  </style>
</head>

<body>
  <!-- Navigation Bar -->
  <?php include 'navigation.php'; ?>
  <div class="content mt-5"> <h1> 


  </h1> <br><br><br>
  </div>
  <div class="container mt-5 " >
    <div class="row">
      <!-- Left Side: Contact Form -->
      <div class="col-lg-7">
        <div class="form-section">
          <h2>Send Us a Message</h2>
          <p>Got questions or concerns? Don’t hesitate to contact us for reliable car rental services.</p>

          <form action="assets/php/UserFunctions/submit_message.php" method="POST" onsubmit="return validateForm()">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                <select id="subject" name="subject" class="form-select" required>
                  <option value="">Please Select...</option>
                  <option value="General Inquiry">General Inquiry</option>
                  <option value="Booking Issue">Booking Issue</option>
                  <option value="Feedback">Feedback</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="rentalType" class="form-label">Rental Type <span class="text-danger">*</span></label>
                <select id="rentalType" name="rental_type" class="form-select" required>
                  <option value="">Please Select...</option>
                  <option value="Short-term">Short-term</option>
                  <option value="Long-term">Long-term</option>
                  <option value="Luxury">Luxury</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" id="firstName" name="first_name" class="form-control" required placeholder="John" />
              </div>
              <div class="col-md-6">
                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" id="lastName" name="last_name" class="form-control" required placeholder="Doe" />
              </div>
            </div>
            <div class="mb-3">
              <label for="mobileNumber" class="form-label">Mobile Number <span class="text-danger">*</span></label>
              <input type="tel" id="mobileNumber" name="mobile_number" class="form-control" required
                placeholder="+94123456789" />
            </div>
            <div class="mb-3">
              <label for="emailAddress" class="form-label">Email Address <span class="text-danger">*</span></label>
              <input type="email" id="emailAddress" name="email_address" class="form-control" required
                placeholder="john.doe@example.com" />
            </div>
            <div class="mb-3">
              <label for="dateRange" class="form-label">Date Range <span class="text-danger">*</span></label>
              <input type="text" id="dateRange" name="date_range" class="form-control" required
                placeholder="Select date range" onfocus="(this.type='date')" onblur="(this.type='text')" />
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Your Message/Questions <span class="text-danger">*</span></label>
              <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="privacyPolicy" name="privacy_policy" required />
              <label class="form-check-label" for="privacyPolicy">I consent to Privacy Policy and opt-in for marketing
                communications.</label>
            </div>
            <div class="text-center">
              <button type="submit" class="btn submit-btn btn-lg">Submit</button>
            </div>
          </form>

          <script>
            function validateForm() {
              const privacyPolicy = document.getElementById('privacyPolicy');
              if (!privacyPolicy.checked) {
                alert('You must consent to the Privacy Policy before submitting.');
                return false;
              }
              return true;
            }
          </script>
        </div>
      </div>

      <!-- Right Side: Contact Info -->
      <div class="col-lg-5">
        <div class="contact-info">
          <h3>PrimeRide Car Rental</h3>
          <p><i class="bi bi-telephone-fill"></i> +94 112 587 968</p>
          <p><i class="bi bi-envelope-fill"></i> info@primeride.com</p>
          <p><i class="bi bi-geo-alt-fill"></i> Kurunegala Road,Katugasthota,Kandy</p>

          <div class="mt-4">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1176.49726260698!2d80.6116000626372!3d7.325868846010255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae368119321d9bd%3A0xb7ba02b4fcb6f062!2sPrasanna%20Rent%20A%20Car%20Service!5e0!3m2!1sen!2ssg!4v1727797464516!5m2!1sen!2ssg"
              width="100%" height="250" style="border: 0" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="content mt-5"> <h1> 


  </h1> <br><br><br>
  <!-- Footer -->
  <?php include 'footer.php'; ?>

  
</body>

</html>
