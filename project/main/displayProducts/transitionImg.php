<?php 
    // Display Default Gallery Image with Transition
    echo '<div class="transition-images">';
        $defimage = json_decode($rs['default_image']);
        if($defimage){
            echo '<img src="' . $defimage . '" alt="' .$rs['alt']. '" class="default" loading="lazy" />';
        }

        $second_image = json_decode($rs['second_image']);
        if($second_image){
            echo '<img src="' . $second_image . '" alt="' .$rs['alt']. '" class="second" loading="lazy" />';
        }
    // Remember to close in after every include
?>
