
<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
session_destroy();
echo "Logging out";
header("refresh:2;url=login.php");
 ?>
