<?php
// Content of database.php

$mysqli = new mysqli('localhost', 'PHP', 'Myg98@20', 'news_website');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
