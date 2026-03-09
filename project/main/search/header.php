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
            OR JSON_SEARCH(p.prod_tag, 'one', :searchJson) IS NOT NULL
            OR JSON_SEARCH(p.prod_color, 'one', :searchJson) IS NOT NULL)";
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
            $conds[] = "JSON_CONTAINS(p.prod_color, $key)"; 
            $params[$key] = '"' . $color . '"'; // Because JSON store them with quoute
        }
        $where[] = "(" . implode(" AND ", $conds) . ")";
    }

    // TAGS
    if (!empty($selectedTags)) {
        $conds = [];
        foreach ($selectedTags as $index => $tag) {
            $key = ":tag$index";
            $conds[] = "JSON_CONTAINS(p.prod_tag, $key)";
            $params[$key] = '"' . $tag . '"';
        }
        $where[] = "(" . implode(" AND ", $conds) . ")";
    }

    $whereSql = !empty($where) ? (" WHERE " . implode(" AND ", $where)) : "";

    // Count total rows
    $countSql = "SELECT COUNT(*) FROM press_on p" . $whereSql;
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

    $sort = $_GET['sort'] ?? 'newest';

    switch ($sort) {
        case 'low_high':
            $orderBy = " ORDER BY prod_price ASC";
            break;

        case 'high_low':
            $orderBy = " ORDER BY prod_price DESC";
            break;

        case 'best':
            $orderBy = " ORDER BY total_orders DESC, RAND()";
            break;

        default:
            $orderBy = " ORDER BY prod_id ASC";
    }

    // list (only rows for this page)
    $currentSql = "SELECT p.*, IFNULL(SUM(ci.quantity), 0) AS total_orders
        FROM press_on p 
        LEFT JOIN cart_items ci 
        ON p.prod_id = ci.prod_id 
        $whereSql 
        GROUP BY p.prod_id 
        $orderBy
        LIMIT :limit OFFSET :offset";
        $listStmt = $DB->prepare($currentSql);

    foreach ($params as $k => $v) {
        $listStmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $listStmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
    $listStmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $listStmt->execute();
    $result = $listStmt->fetchAll(PDO::FETCH_ASSOC);
?>