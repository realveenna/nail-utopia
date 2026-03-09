<?php
    // st = custom set
    // sz = custom size
    // pf = preferences
    // CUSTOM SET JOIN TABLES
    $statement = $DB->prepare("SELECT st.set_name, st.set_id, st.is_default, pf.preference_id, pf.pref_shape, 
        pf.pref_length, pf.pref_size, sz.r_thumb, sz.r_index, sz.r_middle, sz.r_ring, sz.r_pinky, sz.l_thumb, sz.l_index, sz.l_middle, sz.l_ring, sz.l_pinky
        FROM user_custom_set st JOIN preferences pf ON st.preference_id = pf.preference_id
        LEFT JOIN user_custom_sizes sz ON st.set_id = sz.set_id
        WHERE st.id = :userId"); 
        
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $allSet = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
        
<div>

    <!-- No saved preferences -->
    <?php if(!$allSet): ?>
        <h6> No saved preferences</h6>
    <!-- Display saved preferences -->
    <?php else: ?>
         <div class="row gy-3">  
            <?php foreach($allSet as $s): ?> 
                <div class="col-12 col-lg-4">
                    <div class="card" id="card-id-<?=$s['set_id']?>">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-center fw-bold"><?= ucfirst($s['set_name'])?></h5>
                        </div>
                        <div>
                             <ul class="list-group list-group-flush text-center">
                               
                                <li class="list-group-item">
                                    <h5 class="lh-1"><?= $s['pref_shape']?></h5>
                                    <small>Shape</small>
                                </li>
                                <li class="list-group-item">
                                    <h5 class="lh-1"><?= $s['pref_length']?></h5>
                                    <small>Length</small>
                                </li>
                                 <li class="list-group-item">
                                    <h5 class="lh-1"><?= $s['pref_size']?></h5>
                                    <small>Size</small>
                                <?php if ($s['pref_size'] === 'Custom'): ?>
                                    <li class="list-group-item">
                                        <div>
                                            <strong>Left:</strong>
                                            <?= $s['l_thumb'] ?>,
                                            <?= $s['l_index'] ?>,
                                            <?= $s['l_middle'] ?>,
                                            <?= $s['l_ring'] ?>,
                                            <?= $s['l_pinky'] ?>
                                        </div>

                                        <div>
                                            <strong>Right:</strong>
                                            <?= $s['r_thumb'] ?>,
                                            <?= $s['r_index'] ?>,
                                            <?= $s['r_middle'] ?>,
                                            <?= $s['r_ring'] ?>,
                                            <?= $s['r_pinky'] ?>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <small>Size</small>
                                <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <!-- Delete AJAX -->
                            <button class="no-bg" onclick="deletePreference(<?=$s['set_id']?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                            <!-- Make as Default AJAX -->
                            <?php $isDefault = $s['is_default'] === 1; ?>
                            <button class="no-bg" onclick="setDefault(<?=$s['set_id']?>)">
                                <svg id="set-<?=$s['set_id']?>" class="set-icon <?= $isDefault ? 'active' : ''?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>     
            <?php endforeach; ?> 
        </div>
          
    <?php endif; ?>
    <!-- Display button -->
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary primary" href="addPreferences.php" role="button">Add Preference</a>
    </div>

</div>
