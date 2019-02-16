<?php
require '/home/peterming/module3/connectsql.php';
session_start();
if(!isset($_POST['submit'])){
  echo "You need to login from login page";
  exit;
}
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
$username=$mysqli->real_escape_string($_POST['username']);
$password=$mysqli->real_escape_string($_POST['password']);
$hash_password=0;
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $hash_password);
$stmt->fetch();
$stmt->close();

// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($password, $hash_password)){
	// Login succeeded!
	$_SESSION['username'] = $username;
	// Redirect to your target page
  header("location:main.php");
} else{
	// Login failed; redirect back to the login screen
  session_destroy();
  echo "wrong username or password";
  header("refresh:2;url=login.php");
}
 ?>
