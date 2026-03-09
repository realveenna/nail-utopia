<?php
    // st = custom set
    // sz = custom size
    // pf = preferences
    // CUSTOM SET JOIN TABLES
    $statement = $DB->prepare("SELECT st.set_name, st.set_id, st.is_default, pf.preference_id, pf.pref_shape, 
        pf.pref_length, pf.pref_size, sz.r_thumb, sz.r_index, sz.r_middle, sz.r_ring, sz.r_pinky, sz.l_thumb, sz.l_index, sz.l_middle, sz.l_ring, sz.l_pinky
        FROM user_custom_set st JOIN preferences pf ON st.preference_id = pf.preference_id
        LEFT JOIN user_custom_sizes sz ON st.set_id = sz.set_id
        WHERE st.id = :userId ORDER BY is_default DESC"); 
        
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $allSet = $statement->fetchAll(PDO::FETCH_ASSOC);

    if($allSet){
         $sets = [];

     foreach($allSet as $s){
        $sets[$s['set_id']] = array(
            'set_name' => $s['set_name'],
            'is_default'    => (int)$s['is_default'],

            'preference' => array(
                'shape'  => $s['pref_shape'],
                'length' => $s['pref_length'],
                'size'   => $s['pref_size'],
            ),
            'right_hand' => array(
                'Thumb'  => (int)$s['r_thumb'],
                'Index'  => (int)$s['r_index'],
                'Middle' => (int)$s['r_middle'],
                'Ring'   => (int)$s['r_ring'],
                'Pinky'  => (int)$s['r_pinky'],
            ),

            'left_hand' => array(
                'Thumb'  => (int)$s['l_thumb'],
                'Index'  => (int)$s['l_index'],
                'Middle' => (int)$s['l_middle'],
                'Ring'   => (int)$s['l_ring'],
                'Pinky'  => (int)$s['l_pinky'],
            ),
        );
    }

    // Set defaults
    foreach ($sets as $set_id => $set) {
        if ((int)$set['is_default'] === 1) {
            // For some reason if I remove this, the variables below won't be defined
            }
        }
    }

    // Define Variables
    $pSetId = $set_id ?? 0;
    $pShape = $set['preference']['shape'] ?? "";
    $pShape  = $set['preference']['shape'] ?? "";
    $pLength = $set['preference']['length'] ?? "";
    $pSize   = $set['preference']['size'] ?? "";
    $pRight  = $set['right_hand'] ?? [];
    $pLeft   = $set['left_hand'] ?? [];

    // Define Variables for Error Message
    $pShapeErr = $pLengthErr = $pSizeErr = $pLeftErr = $pRightErr =  $pCustomErr = $setNameErr = "";

    $shapeArray = ["Round","Square","Squoval","Oval","Almond","Coffin","Stiletto"];
    $lengthArray = ["S", "M", "L", "XL"];
    $sizeArray = ["XS","S", "M", "L", "Custom"];
    $fingersArray = ['Thumb','Index','Middle','Ring','Pinky'];
    
?>