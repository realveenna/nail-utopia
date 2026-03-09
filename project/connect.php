<?php
//Set variables for the Server Name / Address, Database Name and Username & Password details.
$my_host = "localhost";
$my_db = 'naill_utopia';  //change to match your DB
$my_db_username = "root";
$my_db_passwd = "";

try {
    //PHP Data Objects. PDO is a lean, consistent way to access databases
	$DB = new PDO("mysql:host=$my_host;dbname=$my_db", $my_db_username, $my_db_passwd);
	if(!$DB){
		echo "Database connection can not be established.";
	}

} catch (Exception $ex) {
	echo $ex->getMessage();
}


    // If ever user is a guest
    $_SESSION["userType"] = $_SESSION["userType"] ?? "customer";
    $userId = $_SESSION['userId'] ?? null; 
    $user_session = session_id();
    $userType = $_SESSION["userType"] ?? "customer"; // Session checks type of user

    // Validate Login
     if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
        $userId = $_SESSION["userId"];
        $statement = $DB->prepare("SELECT * FROM userlogin WHERE id = :userId");
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);

        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            include 'logout.php';
        }
    }
	
?>