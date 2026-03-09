
<?php
    function sortResult($value) {
    return '?' . http_build_query(
        array_merge($_GET, [
            'sort' => $value,
            'page' => 1
        ])
    );
}
?>
<!-- List All Product -->
<div class="container-lg">
    <div class="row gy-3 gy-md-4">
        <div class="col-12">
            <!-- Title & Subtitle -->
            <div class="text-center">
                <h2><?= $shopTitle ?></h2> 
                <h6><?= $shopSubTitle ?></h6>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-left">
                    <p>Result Found: <?= $totalRows ?></p>
                </div>
                <div class="d-flex">
                    <!-- Sort By Dropdown -->
                    <div class="dropdown">
                        <button class="dropdown-toggle no-bg px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort By
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?=sortResult('best')?>">Best Seller</a></li>
                            <li><a class="dropdown-item" href="<?=sortResult('low_high')?>">Price (Low → High)</a></li>
                            <li><a class="dropdown-item" href="<?=sortResult('high_low')?>">Price (High → Low)</a></li>
                        </ul>
                    </div>

                    <!-- Filter Button -->
                    <button class="no-bg px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOptions" aria-controls="filterOptions">Filter</button>
                    <!-- Filter offcanvas -->
                    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="filterOptions" aria-labelledby="filterOptionsLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="filterOptionsLabel">Filters</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <hr>
                            <div class="row gy-4">
                            <!-- If admin go to viewDB -->
                            <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] !== 'admin' && $_SESSION['userType'] !== 'staff') :?>
                                <form method="get" action="shop.php?#shopProducts" class="row g-2">
                            <?php else: ?>
                                <form method="get" action="shop.php" class="row g-2">
                            <?php endif;?>
                                <input type="hidden" name="search" value="<?= $search ?>">
                                <!-- Color Filter -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="pcolor" class="form-label">
                                                <h6>Color:</h6>
                                            </label>
                                        </div>
                                        <?php foreach ($arrayColors as $color): ?>
                                            <?php $colorID = str_replace(' ', '-', strtolower($color)); ?>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"  name="selectColor[]" 
                                                    value="<?= $color ?>" id="<?= $colorID ?>"
                                                        <?php 
                                                            if(in_array($color, $selectedColors)){
                                                                echo 'checked';
                                                            }
                                                        ?>>
                                                    <label class="form-check-label  text-capitalize" for="<?= $colorID ?>">
                                                        <?= $color ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                </div>
                                <!-- Tag Filter -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="ptag" class="form-label">
                                                <h6>Tags:</h6>
                                            </label>
                                        </div>
                                            <?php foreach ($arrayTags as $tag): ?>
                                            <?php $tagID = "tag-" . preg_replace('/\s+/', '-', strtolower($tag)); ?>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"  name="selectTag[]" 
                                                        value="<?= $tag ?>" id="<?= $tagID ?>"
                                                        <?php 
                                                            if(in_array($tag, $selectedTags)){
                                                                echo 'checked';
                                                            }
                                                        ?>>
                                                    <label class="form-check-label  text-capitalize" for="<?= $tagID ?>">
                                                        <?= $tag ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <hr>
                                <!-- Apply Filter -->
                                <div class="col-12">
                                    <div class="gap-2 d-flex">
                                        <button type="submit" class="btn btn-primary w-100"> Apply Filter</button>
                                            <!-- If admin go to shop -->
                                        <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] !== 'admin' && $_SESSION['userType'] !== 'staff') :?>
                                            <a href="shop.php" class="btn btn-secondary w-100">Clear</a>
                                        <?php else: ?>
                                            <a href="shop.php" class="btn btn-secondary w-100">Clear</a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </form>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
        <?php 
        if($result){
            echo '<div class="row g-2 gy-3">';
            foreach ($result as $rs) {
                include '../main/displayProducts/displayDB.php';
            }
            echo '</div>'; // Close row 
        }
        echo'</div>'; // Close col-12
?>

<!-- Pagination  -->
<?php if ($totalRows >= 1):?>
    <?php
        $prev = $_GET;
        $next = $_GET; 
        $prev['page'] = max(1, $page - 1); // ensure page does not go below 1
        $next['page'] = min($totalPages, $page + 1); // prevent going above total page
    ?>
        <div class="col-12 d-flex justify-content-center">
            <!-- Bootstrap pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    
                    <!-- http_build_query() keeps filter -->
                    
                    <!-- Previous Button -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($prev) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Page Numbering -->
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <?php 
                            $qp = $_GET; 
                            $qp['page'] = $i; 
                        ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query($qp) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Button -->
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($next) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
<?php endif; ?>

<?php 
    echo'</div>'; // Close row
echo'</div>'; // Close container-lg
?>