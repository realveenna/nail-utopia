<?php


    // Pagination
    $perPage = 8;
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    $offset = ($page - 1) * $perPage;

    $totalRows = 0;
    $totalPages = ceil($totalRows / $perPage);

    // Search and Filter
    $search = $_GET['search'] ?? '';
    $filter = $_GET['filter'] ?? '';

    // Array of Colors
    $arrayColors = ["black","blue","brown","gold","green","grey","burgundy","neutral","orange","pink","purple","red","silver","white","yellow","multicolor","pastel"];
    // Array of Tags
    $arrayTags = ["Featured","Cute","Aerochrome","Chrome","Cateye","Flower","Pearl Aura","French Tip","3D","Minimalist","Floral","Artistic","Seasonal"];

    $selectedColors = $_GET['selectColor'] ?? [];
    $selectedTags = $_GET['selectTag'] ?? [];

    // Make sure it is an array
    if(!is_array($selectedColors)){
       $selectedColors = [$selectedColors]; 
    } 
    if(!is_array($selectedTags)){
       $selectedTags   = [$selectedTags];
    }

    $where = [];
    $params = [];

    // DB for User search product
    if($search !== ''){
        $shopTitle = "Result for " .$search;

        $where[] = "(prod_name LIKE :search
            OR JSON_SEARCH(prod_tag, 'one', :searchJson) IS NOT NULL
            OR JSON_SEARCH(prod_color, 'one', :searchJson) IS NOT NULL)";
        $params[':search'] = "%$search%";
        $params[':searchJson'] = $search;

    }
    elseif(!empty($selectedTags)){
        if(count($selectedTags) === 1){
            $shopTitle = "Result for " .$selectedTags[0];
        }
    }
    elseif(!empty($selectedTags) && !empty($selectedColors)){
        $shopTitle = "Result for Filters";
    }
    

    // COLORS
    if (!empty($selectedColors)) {
        $conds = [];
        foreach ($selectedColors as $index => $color) {
            $key = ":color$index";
            $conds[] = "JSON_CONTAINS(prod_color, $key)"; 
            $params[$key] = '"' . $color . '"'; // Because JSON store them with quoute
        }
        $where[] = "(" . implode(" AND ", $conds) . ")";
    }

    // TAGS
    if (!empty($selectedTags)) {
        $conds = [];
        foreach ($selectedTags as $index => $tag) {
            $key = ":tag$index";
            $conds[] = "JSON_CONTAINS(prod_tag, $key)";
            $params[$key] = '"' . $tag . '"';
        }
        $where[] = "(" . implode(" AND ", $conds) . ")";
    }

    $whereSql = !empty($where) ? (" WHERE " . implode(" AND ", $where)) : "";

    // Count total rows
    $countSql = "SELECT COUNT(*) FROM press_on" . $whereSql;
    $countStmt = $DB->prepare($countSql);
    $countStmt->execute($params);

    $totalRows = (int)$countStmt->fetchColumn();
    $totalPages = (int)ceil($totalRows / $perPage);

    if($totalRows <= 0){
        $shopTitle = "No Result Found!";
        $shopSubTitle = "Please try again with different filters";
    }
    if($search !== '' && $totalRows <= 0){
        $shopTitle = "No Result for " .$search;
        $shopSubTitle = "Please try again with different keyword";
    }

    // list (only rows for this page)
    $currentSql = "SELECT * FROM press_on" . $whereSql . " ORDER BY prod_id DESC LIMIT :limit OFFSET :offset";
    $listStmt = $DB->prepare($currentSql);

    foreach ($params as $k => $v) {
        $listStmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $listStmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
    $listStmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $listStmt->execute();
    $result = $listStmt->fetchAll(PDO::FETCH_ASSOC);


    // If user is an admin
    if(isset($_SESSION["userType"]) && $_SESSION["userType"]  === "admin"){
        // Allow delete product
        if(isset($_POST['btnDeleteProd'])) {
            $pid = $_POST['prod_id']; 

            $statement = $DB->prepare("SELECT prod_id, prod_name, prod_default_image, prod_image FROM press_on WHERE prod_id = :pid");
            // Bind the pid to the placeholder
            $statement->bindParam(':pid', $pid, PDO::PARAM_INT);
            $statement->execute();
            $rs = $statement->fetch(PDO::FETCH_ASSOC);
    
            $pdefImg = json_decode($rs['prod_default_image']);
            $pimages = json_decode($rs['prod_image'],true);

            if($rs){
                // Delete default image file from folder
                if(!empty($pdefImg) && is_string($pdefImg)){
                    $path = realpath(__DIR__ . "/..") . "/" . ltrim(preg_replace('~^\.\./~', '', $pdefImg), '/');
                    if (file_exists($path)) {
                        unlink(filename: $path);
                    }
                }
                // Delete array of files from folder
                if(!empty($pimages) && is_array($pimages)){
                    foreach ($pimages as $img){
                        if (!empty($img) && is_string($img)) {
                        $path2 = realpath(__DIR__ . "/..") . "/" . ltrim(preg_replace('~^\.\./~', '', $img), '/');
                            if (file_exists($path2)) {
                                unlink($path2);
                            }
                        }
                    }
                }
          
                $title = $rs['prod_name'];
                $deleteDB = $DB->prepare("DELETE FROM press_on WHERE prod_id = ?");
                $deleteDB->bindParam(1, $pid, PDO::PARAM_INT);
                $deleteDB->execute();

                //if successful then the database should generate 1 row that matches our login details
                $count = $deleteDB->rowCount();
                if($count > 0){
                    $_SESSION['success'] = $title.  "has been deleted successfully!";
                }else{
                    $_SESSION['errors'] = "Failed to delete!";
                }
            }
            else{
                $_SESSION['errors'] = "Product Not Found!";
            }
            header('Location: shop.php'); 
            exit;
        } 
    }
?>