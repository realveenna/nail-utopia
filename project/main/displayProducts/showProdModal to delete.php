<?php
    require_once __DIR__ . '/../../connect.php';

    $pid = $_POST["pid"];

    // Prepare the SQL statement with a placeholder
    $statement = $DB->prepare("SELECT * FROM press_on WHERE prod_id = :pid");

    // Bind the pid to the placeholder
    $statement->bindValue(':pid', $pid, PDO::PARAM_INT);

    // Execute the statement
    $statement->execute();

    // Fetch the single result
    $rs = $statement->fetch(PDO::FETCH_ASSOC);

?>


<!-- Modal -->
<div class="modal fade" id="ajaxProdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ajaxProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ajaxProdModalLabel">Result</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modan Body Content -->
            <div class="modal-body">
                <!-- Result Found -->
                <?php if($rs): ?>
                    <?php include 'singleProduct.php';?>
                <!-- Product Not Found -->
                <?php else: ?>
                        <p class="text-danger"> No result found. Please try to search another product.</p>
                <?php endif; ?>
            </div>

            <!-- Modal Footer Buttons -->
            <div class="modal-footer">
                <!-- Buttons Optionfor Admin -->
                    <!-- Modify or delete button -->
                <?php if($rs && isset($_SESSION['userType']) && $_SESSION['userType'] === 'admin'): ?>
                    <input type="hidden" name="pid" value="<?= $rs['prod_id'] ?>">
                    <button type="button" class="btn btn-secondary" name="btnModifyProd" value="btnModifyProd">Modify</button>
                    <button type="button" class="btn btn-secondary" name="btnDeleteProd" value="btnDeleteProd">Delete</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>

                <!-- Button Option for Customer-->
                <?php else: ?>
                    <!-- Add to cart or Back button -->
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>