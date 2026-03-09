<?php
    // Convert Array Color to String
    $colors = json_decode($rs['prod_color'], true);
    $colorText = implode(" , ", $colors);

    // Convert Array Tag to String
    $tags = json_decode($rs['prod_tag'], true);
    $tagText = implode(" , ", $tags);

    // Display Products in Database
    echo '<div class="my-card col-6 col-md-3">';

    // Card Body Container for Products
    echo '
        <div class="my-card-body no-underline">';

    // If admin display id
    if(isset($_SESSION["userType"]) && ($_SESSION["userType"]  === "admin" || $_SESSION["userType"]  === "staff") ){
        echo'
            <small class="card-text">Id: '.$rs['prod_id'].'</small>
            <a href="viewProd.php?prod_id='.$rs['prod_id'].'">';
    }
    else{
        echo'
        <a href="../main/addCart.php?prod_id=' . $rs['prod_id'] . '&prod_price='.$rs['prod_price'].'">';
    }
    
    include 'transitionProd.php';

    // If user is an admin, display modify svg
    if(isset($_SESSION["userType"]) && ($_SESSION["userType"]  === "admin" || $_SESSION["userType"]  === "staff") ){
     echo ' 
        <div class="float-svg-con">
            <div class="col-12">
                <form method="post" id="btnDeleteProd">
                    <input type="hidden" name="prod_id" value="' . $rs['prod_id'] . '">
                    <button type="submit" class="float" name="btnDeleteProd">
                        <svg class="float-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="col-12">
                    <a href="viewModify.php?prod_id='.$rs['prod_id'].'">
                        <button type="submit" class="float" name="btnDeleteProd" class="float" name="btnModifyProd">
                        <svg class="float-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        </button
                    </a>
            </div>
        </div>
        ';
    }
    else{
        echo'
         <div class="float-svg-con">
            <div class="col-12">
                    <button type="submit" class="float">
                        <svg class="float-svg mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </button>
                </a>
            </div>
        </div>
        ';
    }
    
    echo '</div>'; // Close tag product-images

        
        // Product details
        echo'
            <strong >'.$rs['prod_name'].'</strong>
            <p class="card-text">Price: '.$rs['prod_price'].'</p>
            ';

    echo '</a>';
    echo '</div>'; // Close card-body
    echo '</div>'; // Close card


?>
