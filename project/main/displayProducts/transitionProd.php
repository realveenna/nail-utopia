<?php 
    // Display Default Product Image with Transition
    echo '<div class="transition-images with-float-svg">';
        $defimage = json_decode($rs['prod_default_image']);
        if($defimage){
            echo '<img src="' . $defimage . '" alt="' .$rs['prod_name']. '" class="default" loading="lazy" />';
        }

        $second_image = json_decode($rs['prod_image'],true);
        if(!empty($second_image[0])){
            echo '<img src="' . $second_image[0] . '" alt="' .$rs['prod_name']. '" class="second" loading="lazy" />';
        }
    // Remember to close in after every include
?>