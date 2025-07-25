<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride Car Rental | FAQs</title>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    .faq-header {
      background-color: #fff;
      padding: 40px 0;
      text-align: center;
      margin-top: 100px;
    }

    .faq-header h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .accordion-button:not(.collapsed) {
      background-color: #d4002a;
      color: white;
    }

    .accordion-button {
      border: 1px solid #d4002a;
    }

    .accordion-button:focus {
      box-shadow: none;
    }

    .faq-body {
      padding: 5px;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <?php include 'navigation.php'; ?>


  <!-- FAQ Header Section -->
  <div class="faq-header">
    <h1>Frequently Asked Questions</h1>
    <p>Your questions about Prime Ride Car Rental answered.</p>
  </div>

  <!-- FAQ Section -->
  <div class="container faq-body">
    <div class="accordion" id="faqAccordion">

      <!-- FAQ Items -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne"
            aria-expanded="true" aria-controls="faqCollapseOne">
            1. How do I make a booking?
          </button>
        </h2>
        <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            You can book a vehicle by logging into your account, selecting a vehicle, and filling out the booking form with your pickup and drop-off dates.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo"
            aria-expanded="false" aria-controls="faqCollapseTwo">
            2. Do I need to create an account to book?
          </button>
        </h2>
        <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Yes, you must sign up and log in to your account to make a booking so we can track your rental history and contact you if needed.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree"
            aria-expanded="false" aria-controls="faqCollapseThree">
            3. What documents do I need?
          </button>
        </h2>
        <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            No, you don't.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingFour">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour"
            aria-expanded="false" aria-controls="faqCollapseFour">
           4. How do I pay for the booking?
          </button>
        </h2>
        <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
           When filling the Rent form you receives Payement Details. You have to transfer 50% from your total rental as Advance payment.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingFive">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFive"
            aria-expanded="false" aria-controls="faqCollapseFive">
            5. Can I cancel or change my booking?
          </button>
        </h2>
        <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Yes, you can contact our support team to request booking changes or cancellations. Make sure to do so before the pickup date.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingSix">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseSix"
            aria-expanded="false" aria-controls="faqCollapseSix">
            6. Can I return the car to a different location?
          </button>
        </h2>
        <div id="faqCollapseSix" class="accordion-collapse collapse" aria-labelledby="faqHeadingSix"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Yes, Prime Ride allows one-way rentals. You can return the car to a different location, but additional fees
            may apply.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingSeven">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseSeven"
            aria-expanded="false" aria-controls="faqCollapseSeven">
            7. Is fuel included in the rental price?
          </button>
        </h2>
        <div id="faqCollapseSeven" class="accordion-collapse collapse" aria-labelledby="faqHeadingSeven"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            No, fuel is not included. You are expected to return the car with the same fuel level as when you picked it up.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingEight">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseEight"
            aria-expanded="false" aria-controls="faqCollapseEight">
            8. How can I contact Prime Ride support?
          </button>
        </h2>
        <div id="faqCollapseEight" class="accordion-collapse collapse" aria-labelledby="faqHeadingEight"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            You can contact us through the message form on our website or call our hotline number provided in the footer section.
          </div>
        </div>
      </div>

    </div>
  </div>

  
  <?php include "footer.php"; ?>
  
  <script defer src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
  
</body>

</html>
