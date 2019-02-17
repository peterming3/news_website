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
$id=$_POST['id'];
//display article
$button="edit_comment";
$content="";
  $stmt = $mysqli->prepare("select content from comments where id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('is',$id,$_SESSION['username']);
  $stmt->execute();

  $stmt->bind_result($content);
  $stmt->fetch();
  $stmt->close();
  if(empty($content)){
    die("Something wrong");
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>manage comment</title>
    <style type="text/css">
      textarea.title{
        left: auto;
        font:20px Times;
        width: 1300px;
        height:30px;
      }
      textarea.content{
        font:15px Times New Roman;
        width: 1300px;
        height:800px;
        left:auto;
        display:block;
      }
    </style>
  </head>
  <body>
    <form  action="manage_story.php" id="edit_comment" method="post">
      <input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <input type="submit" name="<?php echo $button ?>" value="submit">
    </form>
    <textarea
    class= 'content' name="content" form="edit_comment"
    ><?php echo "$content"; ?></textarea>
  </body>
</html>
