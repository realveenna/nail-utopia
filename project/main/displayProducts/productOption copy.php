    <!-- Form Input Group -->
    <form method="post" class="row gy-2" novalidate>
        <!-- Preference Name Only for Account Page-->
        <?php if(isset($isAddPreference) && $isAddPreference === true): ?>
            <div class="col-12">
                <label for="set_name" class="form-label">Preference Name:</label>
                <input type="text" class="form-control" name="set_name" id="set_name" placeholder="Enter Preference Name: "
                    value="<?php $set_name;?>">
                <h6 class="error"><?php echo $setNameErr;?></h6>
            </div>
        <?php else: ?>

            <!-- Prod ID -->
            <input type="hidden" name="pID" value="<?= $rs['prod_id'] ?>">

            <!-- Use Custom Set -->
           <?php if(isset($_SESSION['loggedIn'])):?>
            <div class="col-12">
                <label for="userPref" class="form-label">Custom Preference:
                    <a href="guidelines.php#custom-set" class="info-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </a> 
                </label>
                <select class="form-select" aria-label="userPref"  name="userPref" id="userPref" onchange="selectSetChanged(this.value)">
                    <?php foreach ($sets as $set_id => $s): ?>
                        <option value="<?= (int)$set_id?>"
                            <?php 
                                if($s === $pSetId){
                                    echo 'selected';
                                }
                            ?>>
                            <?= $s['set_name'] ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="0">None</option>
                </select>
            </div>
           <?php endif ;?>
        <?php endif; ?>
        <!-- Shape -->
        <div class="col-12">
            <label for="pShape" class="form-label">Shape:
                <a href="guidelines.php#shape" class="info-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                </a> 
                </label>
                <select class="form-select" aria-label="shape"  name="pShape" id="pShape">

                    <option value="" selected disabled hidden>
                        Select a Nail Shape
                    </option>
                    <?php foreach ($shapeArray as $shape): ?>
                        <option value="<?= $shape ?>"
                        <?php 
                            if($shape === $pShape){
                                echo 'selected';
                            }
                        ?>>
                        <?= $shape ?></option>
                    <?php endforeach; ?>
                    
                </select>
                <h6 class="error"><?php echo $pShapeErr;?></h6>
        </div>
        
        
        <!-- Length -->
        <div class="col-12">
            <label for="pLength" class="form-label">Length: 
                <a href="guidelines.php#length" class="info-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                </a> 
            </label>
            <div class="row gy-2 gx-2 row-cols-auto">
                <?php foreach ($lengthArray as $length): ?>
                    <?php $pLengthID = "pLength". $length; ?>
                    <div class="col">
                        <input type="radio" name="pLength" class="btn-check " 
                            id="<?= $pLengthID ?>" value="<?= $length?>"
                            <?php 
                                if($length === $pLength){
                                    echo 'checked';
                                }
                            ?>>
                        <label class="btn btn-outline-primary btn-radio" for="<?= $pLengthID ?>">
                            <?= $length?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <h6 class="error"><?php echo $pLengthErr;?></h6>
        </div>

        <!-- Size -->
        <div class="col-12">
            <label for="pSize" class="form-label">Size: 
                <a href="guidelines.php#size" class="info-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                </a> 
            </label>    
                <div class="row gy-2 gx-2 row-cols-auto">
                <?php foreach ($sizeArray as $size): ?>
                    <?php $pSizeID = "pSize". $size; ?>
                    <div class="col">
                        <input type="radio" name="pSize" class="btn-check" 
                            id="<?= $pSizeID ?>" value="<?= $size?>"
                            <?php 
                                if($size === $pSize){
                                    echo 'checked';
                                }
                            ?>>
                        <label class="btn btn-outline-primary btn-radio" for="<?= $pSizeID ?>">
                            <?= $size?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <h6 class="error"><?php echo $pSizeErr;?></h6>
        </div>

        <!-- Custom Size -->
        <div class="col-12 d-none" id="CustomDiv">
            <label for="pCustomSize" class="form-label">Custom Size: </label>
            <!-- Left Hand Size Table Input -->
            <div class="col-12" id="leftHand">
                <p>Measure Left Fingernails in mm</p>
                <table class="table table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <?php foreach ($fingersArray as $finger): ?>
                                <th scope="col" class="text-dark"><?= $finger ?></th>
                            <?php endforeach;?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($fingersArray as $finger): ?>
                                <td>
                                    <input type="number" name="left[<?=$finger?>]"  
                                    class="form-control text-center" min="7" max="20"
                                    value="<?= $pLeft[$finger] ?? '' ?>">
                                </td>
                            <?php endforeach;?>
                        </tr>
                    </tbody>
                </table>
                <h6 class="error"><?php echo $pLeftErr;?></h6>
            </div>
            <!-- Right Hand Size Table Input -->
            <div class="col-12" id="rightHand">
                <p>Measure Right Fingernails in mm</p>
                <table class="table table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <?php foreach ($fingersArray as $finger): ?>
                                <th scope="col" class="text-dark"><?= $finger ?></th>
                            <?php endforeach;?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($fingersArray as $finger): ?>
                                <td>
                                    <input type="number" name="right[<?=$finger?>]"  
                                    class="form-control text-center" min="7" max="20"
                                    value="<?= $pRight[$finger] ?? '' ?>">
                                </td>
                            <?php endforeach;?>
                        </tr>
                    </tbody>
                </table>
                <h6 class="error"><?php echo $pRightErr;?></h6>
                <h6 class="error"><?php echo $pCustomErr;?></h6>
            </div>
        </div>
        <!-- Buttons -->
        <div class="col-12">
            <!-- If in account page -->
            <?php if(isset($isAddPreference) && $isAddPreference === true): ?>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary mb-3" name="btnAddPreference"
                        value="btnAddPreference" >Add Preference</button>
                </div>
            <!-- In add cart page -->
            <?php else: ?>
                    <button type="submit" class="btn btn-primary w-100" name="btnAddCart"
                        value="btnAddCart">Add to Cart</button>
            <?php endif; ?>
        </div>
    </form>