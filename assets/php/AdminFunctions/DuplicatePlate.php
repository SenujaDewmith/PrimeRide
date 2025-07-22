<!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <title>License Plate Exists</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
          </head>
          <body>
            <!-- Bootstrap Modal -->
            <div class="modal fade show" id="errorModal" tabindex="-1" aria-modal="true" role="dialog" style="display: block;">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                  <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Duplicate Entry</h5>
                  </div>
                  <div class="modal-body">
                    This license plate is already registered!
                  </div>
                  <div class="modal-footer">
                    <button onclick="history.back()" class="btn btn-danger">Go Back</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-backdrop fade show"></div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
              // Auto go back after 3 seconds
              setTimeout(function() {
                history.back();
              }, 3000);
            </script>
          </body>
          </html>'