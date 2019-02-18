<?php
require '/home/peterming/module3/connectsql.php';
session_start();
if(!(isset($_SESSION['token'])&&isset($_POST['token']))){
  echo "You have to log in";
  header("refresh:2;url=login.php");
  exit;
}
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$username=$_SESSION['username'];
if($username=="guest"){
  die("you are a guest and you have no stories in your account.");
}
//handle add story
if(isset($_POST['add'])){
  $title=$_POST['title'];
  $content=$_POST['content'];
  $stmt = $mysqli->prepare("INSERT INTO story (username,title,content) values(?,?,?)");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('sss',$username,$title,$content);
  $stmt->execute();
  $stmt->close();
  echo "Success";
  header("refresh:2;url=main.php");
}
//handle edit story
if(isset($_POST['edit'])){
  $story_id=$_POST['story_id'];
  $title=$_POST['title'];
  $content=$_POST['content'];
  $stmt = $mysqli->prepare("UPDATE story SET title=?,content=? where story_id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('ssis',$title,$content,$story_id,$username);
  $stmt->execute();
  $stmt->close();
  echo "Edit Success";
  header("refresh:2;url=main.php");

}
//handle delete story
if(isset($_POST['delete'])){
  $story_id=$_POST['story_id'];
  $stmt = $mysqli->prepare("select title from story where story_id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('is',$story_id,$username);
  $stmt->execute();

  $stmt->bind_result($title);
  $stmt->fetch();
  $stmt->close();
  if(empty($title)){
    die("Something wrong");
  }
  $stmt = $mysqli->prepare("DELETE FROM story  where story_id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('is',$story_id, $username);
  $stmt->execute();
  $stmt->close();
  $stmt = $mysqli->prepare("DELETE FROM comments  where story_id=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('i',$story_id);
  $stmt->execute();
  $stmt->close();
  $stmt = $mysqli->prepare("DELETE FROM links where story_id=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('i',$story_id);
  $stmt->execute();
  $stmt->close();
  echo "Delete Success";
  header("refresh:2;url=main.php");
}

//handle add comment
if(isset($_POST['add_comment'])){
  $story_id=$_POST['story_id'];
  $comment=$_POST['comment'];
  $stmt = $mysqli->prepare("INSERT INTO comments (story_id,username,content) values(?,?,?)");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('iss',$story_id,$username,$comment);
  $stmt->execute();
  $stmt->close();
  echo "Success";
  header("refresh:0;url=display_article.php?story_id=$story_id");

}
if(isset($_POST['edit_comment'])){
  $id=$_POST['id'];
  $content=$_POST['content'];
  $stmt = $mysqli->prepare("UPDATE comments SET content=? where id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('sis',$content,$id,$username);
  $stmt->execute();
  $stmt->close();
  echo "Edit Success";
  header("refresh:2;url=main.php");
}
if(isset($_POST['delete_comment'])){
  $id=$_POST['id'];
  $stmt = $mysqli->prepare("DELETE FROM comments where id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('is',$id, $username);
  $stmt->execute();
  $stmt->close();
  echo "Delete Success";
  header("refresh:2;url=main.php");
}
if(isset($_POST['delete_link'])){
  $link_id=$_POST['link_id'];
  $stmt = $mysqli->prepare("DELETE FROM links where id=? and username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('is',$link_id, $username);
  $stmt->execute();
  $stmt->close();
  echo "Delete Success";
  header("refresh:2;url=main.php");
}
if(isset($_POST['change_password'])){
  $oldpassword=$mysqli->real_escape_string($_POST['oldpassword']);
  $newpassword=$mysqli->real_escape_string($_POST['newpassword']);
  if(empty($newpassword)){
    die("cannot be empty password");
  }
  $hash_password=0;
  $stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  // Bind the parameter
  $stmt->bind_param('s', $username);
  $stmt->execute();
  
  // Bind the results
  $stmt->bind_result($cnt, $hash_password);
  $stmt->fetch();
  $stmt->close();
  
  // Compare the submitted password to the actual password hash
  
  if($cnt == 1 && password_verify($oldpassword, $hash_password)){
    //right old password
    $stmt = $mysqli->prepare("UPDATE users SET password=? where username=?");

    if(!$stmt){
      printf("fuck: %s\n", $mysqli->error);
      exit;
    }
  
    $hash_password=password_hash("$newpassword", PASSWORD_DEFAULT);
  
    $stmt->bind_param('ss',  $hash_password,$username);
  
    $stmt->execute();
  
    $stmt->close();
  
    echo"Success";
  
    header("refresh:1;url=login.php");
  
    exit;
  } else{
    // wrong old password
    echo "wrong password";
    header("refresh:2;url=manage.php");
    exit;
  }
}
//handle add link
if(isset($_POST['edit_link'])){
  $story_id=$_POST['story_id'];
  $content=$_POST['content'];
  $stmt = $mysqli->prepare("INSERT INTO links (story_id,username,content) values(?,?,?)");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('iss',$story_id,$username,$content);
  $stmt->execute();
  $stmt->close();
  echo "Success";
  header("refresh:0;url=display_article.php?story_id=$story_id");

}
if(isset($_POST['edit_profile'])){
  $nickname=$_POST['nickname'];
  $personal_web=$_POST['personal_web'];
  $profile_photo=$_POST['profile_photo'];
  $stmt = $mysqli->prepare("UPDATE personal_profile SET nickname=?,personal_web=?,profile_photo=? where username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('ssss',$nickname,$personal_web,$profile_photo,$username);
  $stmt->execute();
  $stmt->close();
  echo "Edit Success";
  header("refresh:2;url=main.php");
}
 ?>
