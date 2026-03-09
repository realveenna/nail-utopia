<?php 
    if(!isset($_SESSION["userdb"]))
    { 
        echo 
        '
            <a href="login.php">
                <button class="primary">Login</button>
            </a>
        ';
    }
    else{
        echo 
        '
            <a href="logout.php">
                <button class="primary">Logout</button>
            </a>
        ';
    }
?>