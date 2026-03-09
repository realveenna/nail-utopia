<?php    
 if(isset($_POST['btnSelectPressOn'])) {
    $pid = $_POST['prod_id']; 
    
    $statement = $DB->prepare("SELECT * FROM press_on WHERE prod_id = '$pid'");
    $statement->execute();
    $select = $statement->fetch();

        if(!empty($select)){
            $defimage = json_decode($select['prod_default_image']);
        if($defimage){
            echo '<img src="' . $defimage . '" alt="' .$select['prod_name']. '" class="default">';
        }

        $second_image = json_decode($select['prod_image'],true);
        if (!empty($second_image)) {
            echo '<img src="' . $second_image[0] . '" alt="' . $select['prod_name'] . '" class="second">';
        }
    }
 }
?>
