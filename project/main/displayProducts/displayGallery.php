<?php
    // Date
    $dateRaw = $rs['upload_date'];
    $date = date('M-d-Y', strtotime($dateRaw)); 

    echo '<div class="my-card col-12 col-sm-6 col-lg-4">';

    // Card body container for images
    echo '
        <div class="my-card-body">';
    
        include 'transitionImg.php';

    // If user is an admin, display modify svg
    if(isset($_SESSION["userType"]) && $_SESSION["userType"]  === "admin"){

        echo ' 
            <div class="float-svg-con" id="adminModifyGallery">
                <div class="col-12">
                    <form method="post" id="btnDeleteGallery">
                        <input type="hidden" name="id" value="' . $rs['id'] . '">
                        <button type="submit" class="float" name="btnDeleteGallery">
                            <svg class="float-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        ';
    }

    echo '</div>'; // Close transitionImg.php

    // If user is an admin, display more gallery details
    if(isset($_SESSION["userType"]) && $_SESSION["userType"]  === "admin"){
        echo '<p>ID: '.$rs['id'].'</p>';
    }

    // Gallery details
    echo '
       <div class="d-flex justify-content-between">
            <strong class="card-title capitalize"> '.$rs['image_title'].' </strong> <br>
            <small class="fw-light text-muted"> '.$date.' </small>
        </div>
        <p> '.$rs['caption'].' </p> <br>
        ';
    
    echo '</div>'; // Close card-body
    echo '</div>'; // Close card

?>
