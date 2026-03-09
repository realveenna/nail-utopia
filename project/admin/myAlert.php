
<?php
    // On load clear success message
    $success = $_SESSION['success'] ?? "";
    unset($_SESSION['success']);

    // On load clear error message
    $errors = $_SESSION['errors'] ?? "";
    unset($_SESSION['errors']);
?>

<!--  Close Alert Message  -->
<script>
    window.setTimeout(function() {
        $(".myAlert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
</script>

<!--Success Alert Message -->
<?php if(!empty($success)): ?>
    <div class="container-lg alertTop">
        <div class="position-fixed alert alert-success alert-dismissible fade show myAlert"  role="alert">
            <h6 class="success"><?php echo $success;?></h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
    </div>
<?php endif; ?>

<!--Error Alert Message -->
<?php if(!empty($errors)): ?>
    <div class="container-lg alertTop">
        <div class="position-fixed alert alert-danger alert-dismissible fade show myAlert"  role="alert">
            <h6 class="danger"><?php echo $errors;?></h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
    </div>
<?php endif; ?>