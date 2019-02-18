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
//display current profile information
$username=$_SESSION['username'];
  $stmt = $mysqli->prepare("select nickname,personal_web,profile_photo from personal_profile where username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s',$username);
  $stmt->execute();

  $stmt->bind_result($nickname,$personal_web,$profile_photo);
  $stmt->fetch();
  $stmt->close();
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>manage profile</title>
    <link rel="stylesheet" type="text/css" href="manage_profile.css">
  </head>
  <body>
    
    <p>Nickname: </p><textarea
    class='nickname' name="nickname" form="edit_profile"
    ><?php echo "$nickname" ;?></textarea>
    <p>Personal webpage: </p><textarea
    class= 'personal_web' name="personal_web" form="edit_profile"
    ><?php echo "$personal_web"; ?></textarea>
    <p>Profile Photo: </p><textarea
    class= 'profile_photo' name="profile_photo" form="edit_profile"
    ><?php echo "$profile_photo"; ?></textarea>
    <img src="<?php echo $profile_photo ?>" alt="Cannot show">
    <form  action="manage_story.php" class="edit_profile" id="edit_profile" method="post">
      <input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
      <input type="submit" name="edit_profile" value="Confirm">
    </form>
  </body>
</html>
