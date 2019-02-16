
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 	<head>
 		<meta charset="utf-8">
 		<title>display_title</title>
 	</head>
 	<body>
		<?php
		require '/home/peterming/module3/connectsql.php';
		session_start();
		$stmt = $mysqli->prepare("select title,story_id from story");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$title;
		$story_id;
		$stmt->bind_result($title,$story_id);

		echo "<ul>\n";
		while($stmt->fetch()){
		  //display titles as url
		  printf("\t<li><a href=display_article.php?story_id=%d>%s<br/></a></li>\n",$story_id,htmlentities($title));
		}
		echo "</ul>\n";

		$stmt->close();
		 ?>


 		<form class="logout" action="logout.php" method="post">
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
 			<input type="submit" name="logout" value="logout">
    </form>
 	</body>
 </html>
