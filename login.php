
<?php
require '/home/peterming/module3/connectsql.php';
session_start();
$token=bin2hex(openssl_random_pseudo_bytes(32));
$_SESSION['token']=$token;
$_SESSION['username']="guest";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>login_page</title>
    <link rel="stylesheet" type="text/css" href="login.css">
  </head>
  <body>
  
  <div class= 'input'> 
  <form class="login" action="validuser.php" method="post">

      <input type="text" name="username" placeholder="Username">
      <br/><br/>

      <input type="password" name="password" placeholder="Password">
      <br/><br/>
      <input type="hidden" name="token" value="<?php echo $token ?>">
      <input type="submit" name="submit" value="login">
    </form>
  </div>
    <p><br></p >
    <div class='form'>
    <form class="register" action="register.php" method="post">
      <input type="submit" name="register" value="Register">
    </form>
    <form class="guest" action="display_title.php" method="post">
      <input type="hidden" name="token" value="<?php echo $token ?>">
      <input type="submit" name="guest" value="Continue as guest">
    </form>
    </form>
    <form action="all_users.php">
      <input type="submit" name="all_user" value="List all users">
    </form>
    </div>
  </body>
</html>