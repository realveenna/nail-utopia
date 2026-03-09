<?php

    if(!isset($_GET['prod_id'])){
        return;
    }

    $id = (int)$_GET['prod_id']; // must be int

    if($id <= 0){
        return;
    }

    $recent = $_COOKIE['recent'] ?? [];

    // must be in array even if one value
    if(!is_array($recent)){
        $recent = [$recent];
    }

    // convert all value to integer
    $recent = array_map('intval', $recent);
    
    // remove current product if exists
    $recent = array_diff($recent, [$id]);

    // place at beginning
    array_unshift($recent, $id);

    // remove duplicates
    $recent = array_unique($recent);

    // keep only 4
    $recent = array_slice($recent, 0, 4);

    // reindex
    $recent = array_values($recent);
    
    // save cookies
    foreach ($recent as $key => $value) {
        setcookie("recent[$key]", $value, time() + (60*60*24*30), "/");
    }
?>