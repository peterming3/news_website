<?php
session_start();
if(!(isset($_SESSION['token'])&&isset($_POST['token']))){
  echo "You have to logged in";
  header("refresh:2;url=login.php");
  exit;
}
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
require '/home/peterming/module3/connectsql.php';
$story_id=$_POST['story_id'];
//display article
$button="add";
$title="";
$content="";
if(isset($_POST['add']))$button="add";
if(isset($_POST['edit'])){
  $button="edit";
  $stmt = $mysqli->prepare("select title,content from story where story_id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('is',$story_id,$_SESSION['username']);
  $stmt->execute();

  $stmt->bind_result($title,$content);
  $stmt->fetch();
  $stmt->close();
  if(empty($title)){
    die("Something wrong");
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>manage story</title>
    <style type="text/css">
      textarea.title{
        left: auto;
        font:20px Times;
        width: 1400px;
        height:30px;
      }
      textarea.story{
        font:15px Times New Roman;
        width: 1400px;
        height:800px;
        left:auto;
      }
    </style>
  </head>
  <body>
    <form  action="manage_story.php" id="edit_story" method="post">
      <input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
      <input type="hidden" name="story_id" value="<?php echo $story_id ?>">
      <input type="submit" name="<?php echo $button ?>" value="submit">
    </form>
    <textarea
    name="title" form="edit_story"
    ><?php echo "$title" ;?></textarea>
    <textarea
    name="content" form="edit_story"
    ><?php echo "$content"; ?></textarea>
  </body>
</html>
