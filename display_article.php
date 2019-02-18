<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>display_article</title>
		<link rel="stylesheet" type="text/css" href="display_article.css">
	</head>
	

	<body>


		<?php
		require '/home/peterming/module3/connectsql.php';
		session_start();
		if(!isset($_GET['story_id'])){
			exit;
		}
		$story_id=$_GET['story_id'];

		//display article
		$stmt = $mysqli->prepare("select title,content from story where story_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('i',$story_id);
		$stmt->execute();
		$title;
		$content;
		$stmt->bind_result($title,$content);
		
		while($stmt->fetch()){

		  printf("<p class=\"title\">%s<br/></p><p>%s</p>",htmlentities($title),htmlentities($content));
		}
		

		$stmt->close();

		//display links
		$stmt = $mysqli->prepare("select content from links where story_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->bind_param('i',$story_id);
		$stmt->execute();
		$username;
		$stmt->bind_result($content);
		echo "<div class=\"links_comments\">\n";
		echo "<div class=\"links\">";
		printf("<p><strong>Links:<br/></strong></p>");
		while($stmt->fetch()){

			printf("<p>%s<br/></p>",htmlentities($content));
		}
		echo "</div>\n";

		$stmt->close();

		//display comments
		$stmt = $mysqli->prepare("select content,username from comments where story_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->bind_param('i',$story_id);
		$stmt->execute();
		$username;
		$stmt->bind_result($content,$username);
		echo "<div class=\"comments\">\n";
		printf("<p><strong>Comment:<br/></strong></p>");
		while($stmt->fetch()){

		  printf("<p>%s:		%s<br/></p>",htmlentities($username),htmlentities($content));
		}
		echo "</div>\n";
		echo "</div>\n";

		$stmt->close();

		 ?>
		 <form class="return" action="main.php" method="post">
		 	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
			<input type="submit" name="return" value="Return">
		 </form>
		 <form action="manage_story.php" class="add_comment" id="add_comment" method="post">
  			<input type="hidden" name="story_id" value=<?php echo $story_id?>>
  			<input type="submit" name="add_comment" value="Add comment">
  			<input type="hidden" name='token' value=<?php echo $_SESSION['token'] ?>>
		</form>
		<textarea name="comment" placeholder="Add your comment here..." cols="60" rows="10" form="add_comment"></textarea> 
	</body>
</html>
