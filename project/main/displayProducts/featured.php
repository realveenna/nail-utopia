<?php
    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT * FROM press_on WHERE JSON_CONTAINS(prod_tag, :featured)");
    $statement->bindValue(':featured' , json_encode("Featured"), PDO::PARAM_STR);
    //Executes a prepared statement
    $statement->execute();

    //Returns an array containing all of the remaining rows in the result set
    $result = $statement->fetchAll();
?>

<?php 
    echo '<div id="ListFeatured">';
    // Return the number of rows in result set
        if($result){
            echo '<div class="row g-2">';
            $rowCount = 0;
            foreach ($result as $rs) {
                if($rowCount == 4){
                    break;
                }
                else{
                    include 'displayDB.php';
                    $rowCount++;    
                }
            }
            echo '</div>'; // Close row 
        }else{
            echo "No result Found";
        }
    echo'</div>'; // Close container-lg
?>