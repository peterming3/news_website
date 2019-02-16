<?php
require 'display_title.php';
//session_start();
if($_SESSION['username']=="guest"){
   exit;
}

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>existing_user</title>
   </head>
   <body>

 <form class="user_manage" action="manage.php" method="post">
   <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
   <input type="submit" name="user_manage" value="Manage Account">
  </form>
   </body>
 </html>
