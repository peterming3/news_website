<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>account page</title>
    <link rel="stylesheet" type="text/css" href="manage.css">
</head>
<body>
<?php
require '/home/peterming/module3/connectsql.php';
session_start();
if(!isset($_SESSION['username'])){
  echo "You have to log in";
  header("refresh:2;url=login.php");
  exit;
}
$username=$_SESSION['username'];
if($username=="guest"){
    die("you are a guest.");
}

$stmt = $mysqli->prepare("select title,story_id from story where username=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}
$stmt->bind_param('s',$username);
$stmt->execute();
$title;
$story_id;
$result=$stmt->get_result();
// header("Location:accountpage.php");
// echo "<ul>\n";
// while($stmt->fetch()){
  
//   //display titles as url
//   // printf("\t<li><a href=display_article.php?story_id=%d>%s<br/></a></li>\n",$story_id,htmlentities($title));
//   // printf(" <form class=\"edit\" action=\"edit_story.php\" method=\"post\">
//   //    <input type=\"hidden\" name=\"token\" value=%s>
//   //    <input type=\"hidden\" name=\"story_id\" value=%d>
//   //    <input type=\"submit\" name=\"edit\" value=\"edit\">
//   //  </form>",$_SESSION['token'],$story_id);
//   //  printf(" <form class=\"delete\" action=\"manage_story.php\" method=\"post\">
//   //     <input type=\"hidden\" name=\"token\" value=%s>
//   //     <input type=\"hidden\" name=\"story_id\" value=%d>
//   //     <input type=\"submit\" name=\"delete\" value=\"delete\">
//   //   </form>",$_SESSION['token'],$story_id);
//   //   printf("<br/>");
// }

// printf(" <form class=\"add\" action=\"edit_story.php\" method=\"post\">
//    <input type=\"hidden\" name=\"token\" value=%s>
//    <input type=\"hidden\" name=\"story_id\" value=%d>
//    <input type=\"submit\" name=\"add\" value=\"add story\">
//  </form>",$_SESSION['token'],$story_id);
// echo "</ul>\n";
// $stmt->close();
 ?>



    <div class="story">
    <h1>Stories:</h1>
        <?php
        while($row = $result->fetch_assoc()){?>
            <a href="display_article.php?story_id=<?php echo $row['story_id']?>"><?php echo $row['title']?></a>
            <form action="edit_story.php" class="edit" method="POST">
                <input type="submit" value="Edit" name='edit'>
                <input type="hidden" value=<?php echo $row['story_id']?> name='story_id'>
                <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
            </form>
            <form action="manage_story.php" class="delete" method="POST">
                <input type="submit" value="Delete" name='delete'>
                <input type="hidden" value=<?php echo $row['story_id']?> name='story_id'>
                <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
            </form>
            <form action="edit_link.php" class="edit_link" method="POST">
                <input type="submit" name="edit_link" value="Add link">
                <input type="hidden" value=<?php echo $row['story_id']?> name='story_id'>
                <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
            </form>
            <br/>
            <br/>
            <?php } ?>
        <form action="edit_story.php" class='add' method="POST">
            <input type="submit" name="add" value="Add Story">
            <input type="hidden" name="story_id" value=0>
            <input type="hidden" name="token" value=<?php echo $_SESSION['token']?>>
        </form>
        

    </div>
    <div class="comment">

    <h1>Comments:</h1>
    <?php
    $stmt = $mysqli->prepare("select id,story_id,content from comments where username=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $result=$stmt->get_result();
    while($row = $result->fetch_assoc()){?>
    <p><?php echo $row['content'] ?></p>
    <form action="edit_comment.php" class="edit" method="POST">
        <input type="submit" value="Edit" name='edit_comment'>
        <input type="hidden" value=<?php echo $row['id']?> name='id'>
        <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
    </form>
    <form action="manage_story.php" class="delete" method="POST">
        <input type="submit" value="Delete" name='delete_comment'>
        <input type="hidden" value=<?php echo $row['id']?> name='id'>
        <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
    </form>
    
    <?php } ?>
    </div>

    <h1>Links:</h1>
    <?php
    $stmt = $mysqli->prepare("select id,content from links where username=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $result=$stmt->get_result();
    while($row = $result->fetch_assoc()){?>
    <p><?php echo $row['content'] ?></p>
    <form action="manage_story.php" class="delete" method="POST">
        <input type="submit" value="Delete" name='delete_link'>
        <input type="hidden" value=<?php echo $row['id']?> name='link_id'>
        <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
    </form>
    <?php } ?>
    <form action="main.php" class='return'>
        <input type="submit" name="return" value="Return">
    </form>
    <form action="change_password.php" class='change_password' method="Post">
        <input type="submit" name='change_password' value="Change Password">
        <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
    </form>
    <form action="manage_profile.php" method="POST">
        <input type="submit" name="manage_profile" value="Manage Account Information">
        <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
    </form>
</body>
</html>
