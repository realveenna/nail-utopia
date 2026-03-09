<?php
    session_start();
    require_once '../../connect.php';

    header('Content-Type: application/json');
    
    $setId = ($_POST['set_id']);
    $userId = $_SESSION['userId'] ?? null; 

   
    // Define Variables
    $pShape = $pLength = $pSize = $setName = $pSetName = $pSetId = "";

    // st = custom set
    // sz = custom size
    // pf = preferences

    // CUSTOM SET JOIN TABLES
    $statement = $DB->prepare("SELECT st.set_name, st.set_id, st.is_default, pf.preference_id, pf.pref_shape, 
        pf.pref_length, pf.pref_size, sz.r_thumb, sz.r_index, sz.r_middle, sz.r_ring, sz.r_pinky, sz.l_thumb, sz.l_index, sz.l_middle, sz.l_ring, sz.l_pinky
        FROM user_custom_set st JOIN preferences pf ON st.preference_id = pf.preference_id
        LEFT JOIN user_custom_sizes sz ON st.set_id = sz.set_id
        WHERE st.id = :userId AND st.set_id = :setId"); 
        
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->bindValue(':setId', $setId, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    
    // Return data for JS to use
    $sets[] = array(
        'set_id' => (int)$row['set_id'],
        'set_name' => $row['set_name'],
        'is_default' => (int)$row['is_default'],

        'preference' => array(
            'shape'  => $row['pref_shape'] ?? '',
            'length' => $row['pref_length'] ?? '',
            'size'   => $row['pref_size'] ?? '',
        ) ?? '',
        'right' => array(
            'Thumb'  => (int)$row['r_thumb'] ?? '',
            'Index'  => (int)$row['r_index'] ?? '',
            'Middle' => (int)$row['r_middle'] ?? '',
            'Ring'   => (int)$row['r_ring'] ?? '',
            'Pinky'  => (int)$row['r_pinky'] ?? '',
        ) ?? '',

        'left' => array(
            'Thumb'  => (int)$row['l_thumb'] ?? '',
            'Index'  => (int)$row['l_index'] ?? '',
            'Middle' => (int)$row['l_middle'] ?? '',
            'Ring'   => (int)$row['l_ring'] ?? '',
            'Pinky'  => (int)$row['l_pinky'] ?? '',
        ),
    );

    echo json_encode($sets); 

?>