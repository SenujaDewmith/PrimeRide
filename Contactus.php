<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <title>PrimeRide | Contact Us</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin-top: 200px;
      
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
          <p>Got feedbacks or questions? Don’t hesitate to contact us for reliable car rental services.</p>

          <form action="assets/php/UserFunctions/submit_message.php" method="POST" onsubmit="return validateForm()">

            <!-- Title -->
            <div class="mb-2">
              <label for="title" class="form-label">Title</label>
                <select class="form-select form-select-sm" id="title" name="title" required>
                    <option value="">-- Select --</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr">Dr</option>
                    <option value="Rev">Rev</option>
                </select>
            </div>

            <div class="mb-2">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>

            <div class="mb-2">
                <label for="phone" class="form-label">Telephone Number (optional)</label>
                <input type="tel" class="form-control form-control-sm" id="phone" name="phone" maxlength="10" pattern="\d{10}" 
                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" 
                    required>
            </div>

            <!-- <div class="mb-2">
                <label for="basis" class="form-label">Basis of Hire</label>
                <select class="form-select form-select-sm" id="basis" name="basis" required>
                    <option value="">-- Select --</option>
                    <option value="Short Term">Short Term</option>
                    <option value="Long Term">Long Term</option>
                </select>
            </div> -->

            <div class="mb-2">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control form-control-sm" id="message" name="message" rows="3" required></textarea>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="privacyPolicy" name="privacy_policy" required />
              <label class="form-check-label" for="privacyPolicy">I consent to Privacy Policy and opt-in for marketing
                communications.</label>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-sm btn-primary px-3">Submit</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Side: Contact Info -->
      <div class="col-lg-5">
        <div class="contact-info">
          <h3>Prasanna Rent A Car | (Prime Ride)</h3>
          <p><i class="bi bi-telephone-fill"></i> +94 77 766 3798</p>
          <p><i class="bi bi-envelope-fill"></i> prasanna.rentingservices@gmail.com</p>
          <p><i class="bi bi-geo-alt-fill"></i> Kurunegala Road,Katugasthota,Kandy</p>

          <div class="mt-2">
            <iframe
              src="assets/Photo/Content/map.png"
              width="100%" height="330" style="border: 0" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="content mt-5"> <h1> 
  
  </h1> <br><br><br>

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
  <!-- Footer -->
  <?php include 'footer.php'; ?>


  <!-- Real google map location -->
  <!-- <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1176.49726260698!2d80.6116000626372!3d7.325868846010255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae368119321d9bd%3A0xb7ba02b4fcb6f062!2sPrasanna%20Rent%20A%20Car%20Service!5e0!3m2!1sen!2ssg!4v1727797464516!5m2!1sen!2ssg"
    width="100%" height="250" style="border: 0" allowfullscreen="" loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
            
  </iframe> -->

  <script defer src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
