<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride Car Rental | FAQs</title>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script defer src="assets/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
  
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
      padding: 50px;
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
            1. What is the process for renting a car?
          </button>
        </h2>
        <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            To rent a car from Prime Ride, simply browse our selection, select the car that fits your needs, and make a
            reservation online. You can then pick up the car at our designated location or request a delivery service
            for an additional fee.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo"
            aria-expanded="false" aria-controls="faqCollapseTwo">
            2. What documents do I need to rent a car?
          </button>
        </h2>
        <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            You will need a valid driver's license, proof of identification (such as a passport or ID card), and a valid
            credit or debit card for payment. International travelers must also present their travel documents and an
            international driving permit if required.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree"
            aria-expanded="false" aria-controls="faqCollapseThree">
            3. Are there age restrictions for renting a car?
          </button>
        </h2>
        <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Yes, renters must be at least 21 years old. Drivers under the age of 25 may incur a young driver surcharge.
            Some vehicles may also have additional age restrictions.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingFour">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour"
            aria-expanded="false" aria-controls="faqCollapseFour">
            4. Can I rent a car for long-term use?
          </button>
        </h2>
        <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Yes, Prime Ride offers long-term car rentals with flexible rates. You can rent a car for weeks or months
            depending on your need. Please contact us for specific details and pricing.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingFive">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFive"
            aria-expanded="false" aria-controls="faqCollapseFive">
            5. What should I do if the car breaks down?
          </button>
        </h2>
        <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            In the rare event that your rental car breaks down, contact Prime Ride customer service immediately. We
            will arrange for roadside assistance and provide you with a replacement vehicle if necessary.
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
            may apply. Please confirm the drop-off location when making your reservation.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingSeven">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseSeven"
            aria-expanded="false" aria-controls="faqCollapseSeven">
            7. Is insurance included in the rental price?
          </button>
        </h2>
        <div id="faqCollapseSeven" class="accordion-collapse collapse" aria-labelledby="faqHeadingSeven"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Basic insurance coverage is included in the rental price. However, we recommend purchasing additional
            coverage for peace of mind. Options include collision damage waivers, theft protection, and more.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingEight">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseEight"
            aria-expanded="false" aria-controls="faqCollapseEight">
            8. How do I extend my rental period?
          </button>
        </h2>
        <div id="faqCollapseEight" class="accordion-collapse collapse" aria-labelledby="faqHeadingEight"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            To extend your rental, simply contact Prime Ride customer service before your rental period ends. We will
            confirm the extension and update your payment details accordingly.
          </div>
        </div>
      </div>

    </div>
  </div>

  
  <?php include "footer.php"; ?>

  <script src="assets/js/script.js"></script>
  
</body>

</html>
