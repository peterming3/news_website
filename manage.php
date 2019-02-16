<?php
require '/home/peterming/module3/connectsql.php';
session_start();
if(!(isset($_SESSION['token'])&&isset($_POST['token']))){
  echo "You have to logged in";
  exit;
  header("refresh:2;url=login.php");
}
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
$stmt = $mysqli->prepare("select title,story_id from story where username=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}
$username=$_SESSION['username'];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>account page</title>
</head>
<body>
    <div class="story">
        <?php
        while($row = $result->fetch_assoc()){?>
            <a href="display_article.php?story_id="<?php echo $row['story_id']?>><?php echo $row['title']?></a>
            <form action="edit_story.php" class="edit", method="POST">
                <input type="submit" value="Edit" name='edit'>
                <input type="hidden" value=<?php echo $row['story_id']?> name='story_id'>
                <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
            </form>
            <form action="manage_story.php" class="delete", method="POST">
                <input type="submit" value="Delete" name='delete'>
                <input type="hidden" value=<?php echo $row['story_id']?> name='story_id'>
                <input type="hidden" value=<?php echo $_SESSION['token']?> name='token'>
            </form>
            <?php } ?>
        <form action="edit_story.php" class='add',method="POST">
            <input type="submit" name="add" value="Add Story">
            <input type="hidden" name="story_id" value=0>
            <input type="hidden" name="token" value=<?php echo $_SESSION['token']?>>
        </form>
    </div>
</body>
</html>