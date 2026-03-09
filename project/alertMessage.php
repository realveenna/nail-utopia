<?php
    // On load clear success message
    $success = $_SESSION['success'] ?? "";
    unset($_SESSION['success']);

    // On load clear error message
    $errors = $_SESSION['errors'] ?? "";
    unset($_SESSION['errors']);

    $alertOn = (!empty($success) || !empty($errors));
?>

<?php if($alertOn) :?>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          const getModal = document.querySelector('.alertMessage');
          const modal = new bootstrap.Modal(getModal);
          modal.show();
      });
  </script>

  <!-- Modal -->
  <div class="modal fade alertMessage" tabindex="-1" aria-labelledby="alertMessageLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="alertMessageLabel">
                    Alert Message
                  </h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <!-- Modan Body Content -->
              <div class="modal-body">
                  <?php if(!empty($success)): ?>
                      <h6 class="success"><?php echo $success;?></h6>
                  <?php endif; ?>
                  <?php if(!empty($errors)): ?>
                      <h6 class="danger"><?php echo $errors;?></h6>
                  <?php endif; ?>
              </div>
              <!-- Modal Footer Buttons -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
              </div>
          </div>
      </div>
  </div>
<?php endif; ?>