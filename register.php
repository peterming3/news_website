<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
  </head>
  <body>
    <form class="register" action="register.php" method="post">
      <p>username:</p>
      <input type="text" name="username" >
      <p>password</p>
      <input type="text" name="password" >
      <input type="hidden" name="register" value="Register">
      <input type="submit" name="ok" value="OK">
    </form>
  </body>
</html>

<?php
require '/home/peterming/module3/connectsql.php';

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
if(!isset($_POST['register'])){
  echo "You need to register from login page";
  exit;
}
if(isset($_POST['username'])&&isset($_POST['password'])){
  $username=$mysqli->real_escape_string($_POST['username']);
  $password=$mysqli->real_escape_string($_POST['password']);
  $cnt=0;
  //echo "$username";

  $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users where username=?");
  if(!$stmt){
	  printf("Query Prep Failed: %s\n", $mysqli->error);
	  exit;
  }
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->bind_result($cnt);
  $stmt->fetch();
  $stmt->close();
  //echo $cnt;
  if($cnt>=1){
    echo "The username is taken, try another one";

    //clear the post
    $_POST['username']='';
    $_POST['password']='';
    header("refresh:2;url=register.php");
    exit;
  }


  $stmt = $mysqli->prepare("insert into users (username,password) values (?,?)");

  if(!$stmt){
	  printf("fuck: %s\n", $mysqli->error);
	  exit;
  }

  $hash_password=password_hash("$password", PASSWORD_DEFAULT);

  $stmt->bind_param('ss', $username, $hash_password);

  $stmt->execute();

  $stmt->close();

  echo"Success";

  header("refresh:1;url=login.php");

  exit;
}


 ?>
