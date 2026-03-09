<?php
    //Show Recent Viewed Product
    $recentIds = $_COOKIE['recent'] ?? [];
    if (!is_array($recentIds)){
        $recentIds = [$recentIds];
    } 
    $recent = $_COOKIE['recent'] ?? []; 

    // separated by comma
    $placeholders = implode(',', array_fill(0, count($recentIds), '?'));

    $statement = $GLOBALS['DB']->prepare("SELECT * FROM press_on WHERE prod_id IN ($placeholders) ");
    $statement->execute($recentIds);
    $recentProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

    // keep same order as cookie (newest first)
    usort($recentProducts, function($a, $b) use ($recentIds){
        return array_search((int)$a['prod_id'], $recentIds) <=> array_search((int)$b['prod_id'], $recentIds);
    });
?>
  
<!-- Shop All -->
<?php 
    echo '<div class="container-lg py-3 py-md-5" id="ListRecent">
            <div class="row gy-3 gy-md-4 ">
                <div class="col-12">
                    <div class="text-center">
                        <h2>Recently Viewed</h2> 
                        <h6>Browse you recently viewed products</h6>
                    </div>
                </div>
                <div class="col-12">';
                if($recentProducts){
                    echo '<div class="row g-2 gy-3">';
                    foreach ($recentProducts as $rs) {
                        $isRecent = true;
                        include './displayProducts/displayDB.php';
                    }
                    echo '</div>'; // Close row 
                }else{
                    echo "No result Found";
                }
            echo'</div>'; // Close col-12
        echo'</div>'; // Close row
    echo'</div>'; // Close container-lg
?>