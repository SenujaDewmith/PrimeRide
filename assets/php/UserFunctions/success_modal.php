<!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="UTF-8">
                  <title>Success</title>
                  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                  <script defer src="assets/js/bootstrap.bundle.min.js"></script>

                </head>
                <body>
                  <!-- Bootstrap Modal -->
                  <div class="modal fade show" id="successModal" tabindex="-1" aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content border-success">
                        <div class="modal-header bg-success text-white">
                          <h5 class="modal-title">Success</h5>
                        </div>
                        <div class="modal-body">
                          Rental request submitted successfully!
                        </div>
                        <div class="modal-footer">
                          <a href="../../../profile.php" class="btn btn-success">OK</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-backdrop fade show"></div>

                  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                  <script>
                    setTimeout(function() {
                      window.location.href = "../../../profile.php";
                    }, 3000); // Auto redirect after 3 seconds
                  </script>
                </body>
                </html>';