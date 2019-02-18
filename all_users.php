
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>list users</title>
    <link rel="stylesheet" type="text/css" href="all_users.css">
</head>
<body>
<?php 
require '/home/peterming/module3/connectsql.php';
session_start();
		$stmt = $mysqli->prepare("select username,nickname,personal_web,profile_photo from personal_profile");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$title;
		$story_id;
		$stmt->bind_result($username,$nickname,$personal_web,$profile_photo);

        ?>
        <div class="grid">
        <?php
		while($stmt->fetch()){?>
		  <!-- display all users -->
          <div class="user">
          <p>Username: <?php echo $username?></p>
          <p>Nickname: <?php echo $nickname?></p>
          <p>Personal Website: <?php echo $personal_web?></p>
          <img src="<?php echo $profile_photo ?>" onerror="this.src='https://cdn.tutsplus.com/mac/authors/jacob-penderworth/user-black.png'" alt="">
          </div>
        <?php } ?>
        <?php $stmt->close(); ?>
		</div>
</body>
</html>