<?php
session_start();
session_destroy();
header("Cache-control:private");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>SpeakUp Feedback Database Interface</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
		<link rel="stylesheet"type= "text/css"href="styles/speakUp_database.css">
	</head>
	<body>
	<div style="text-align:center;background-color:#008131"  id="header">
		<h2>SPEAK UP DATABASE CONTROL PANEL</h2>
	</div>
	
	<div>
		<h3>Log In</h3>
		<form action="staff_find.php" method="post" enctype="multipart/form-data">
			<label for="usr">User:</label></br>
			<input type="text" name="usr" id="usr"/>
			<label for="key">Key:</label></br>
			<input type="text" name="key" id="key"/>
			<input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	