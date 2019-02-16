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
  </head>
  <body>
    <form class="login" action="validuser.php" method="post">
      <p>username: </p><input type="text" name="username">
      <p>password: </p><input type="text" name="password">
      <input type="hidden" name="token" value="<?php echo $token ?>">
      <input type="submit" name="submit" value="submit">
    </form>
    <p><br></p>
    <form class="register" action="register.php" method="post">
      <input type="submit" name="register" value="Register">
    </form>
    <form class="guest" action="display_title.php" method="post">
      <input type="hidden" name="token" value="<?php echo $token ?>">
      <input type="submit" name="guest" value="Continue as guest">
    </form>
  </body>
</html>
