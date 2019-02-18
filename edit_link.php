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
$story_id=$_POST['story_id'];
?>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Add Link</title>
 </head>
 <body>
     <form action="manage_story.php" id="edit_link" method="POST">
     <input type="submit" name="edit_link" value="Add">
     <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
     <input type="hidden" name="story_id" value=<?php echo $story_id ?>>
     </form>
     <textarea
    class= 'content' name="content" form="edit_link" rows=5 cols=40
    ></textarea>
 </body>
 </html>