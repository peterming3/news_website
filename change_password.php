<?php
session_start();
if(!(isset($_SESSION['token'])&&isset($_POST['token']))){
  echo "You have to log in";
  header("refresh:2;url=login.php");
  exit;
}
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
require '/home/peterming/module3/connectsql.php';

 ?>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Change password</title>
 </head>
 <body>
     <form action="manage_story.php" class="change_password" method="POST">
     <p>Old password: </p><input type="text" name="oldpassword">
     <p>New password: </p><input type="text" name="newpassword">
     <input type="submit" name="change_password" value="Confirm">
     <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
     </form>
 </body>
 </html>