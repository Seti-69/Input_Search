<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>SpeakUp Feedback Database Interface</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
		<link rel="stylesheet"type= "text/css"href="styles/speakUp_database.css">
	</head>
	<?php
	if(!$_SESSION['lginData1'] && !$_SESSION['lginData2']){
		$page='index_logIn.php';
		header('Location:'.$page);
		}
	$name1= $_SESSION['lginData1'];
	$id=$_SESSION['lginData2'];
	include("dbinfo.php");
	$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
    mysql_select_db($database) or die('Could not select database');
	//$query = "SELECT  *FROM staff WHERE key='".$id."'";
	//$result = mysql_query($query);
	//$num = mysql_numrows($result);
	//$user=mysql_result($result,0,"user");
	//echo $user;
	
	mysql_close();
	?>
	<body>
	<div style="text-align:center;background-color:#008131" id="header">
		<h2>SPEAK UP DATABASE CONTROL PANEL</h2>
		
	</div>
	<?php
		echo "<div class='ochreDiv' style='height:30px;'>
		
		<a href='index_logIn.php' style='float:right' title='Log Out'>
		<img  id='logOffBtn'onmouseover='hover(\"over\");' onmouseout='hover(\"out\");'style='margin-top:3px' src='assets/logOut.png' width='32px' height='32px' alt='logOut'></a>
		<p id='logInTxt'style='float:right;margin-top:5px;color:#d5d683'>Logged in: ".$name1."</p></div>";
	?>
	

	<div>
		<h3>SEARCH ALL FEEDBACK</h3>
		<form action="searchFeedBack2.php" method="post" enctype="multipart/form-data">
			<label for="word">By Word:</label></br>
			<input type="text" name="word" id="word"/>
			<input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>SEARCH MEMBERS</h3>
		<form action="searchMembers2.php" method="post" enctype="multipart/form-data">
			<label for="memb">By Name:</label></br>
			<input type="text" name="memb" id="memb"/>
			<input  class="submit"type="submit" name="submit" value="Submit"/>
		</form>
		<form action="searchMembers.php" method="post" enctype="multipart/form-data">
			<label for="memb">By List:</label></br>
			<select type="text" name="memb" id="memb">
			<?php
			include("dbinfo.php");
			$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
			mysql_select_db($database) or die('Could not select database');
			$query = "SELECT  *FROM members WHERE 1 ORDER BY name1";
			$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
			$num = mysql_numrows($result);
			for($a=0;$a<$num;$a++)
			{
			$name1=mysql_result($result,$a,"name1");
			$name2=mysql_result($result,$a,"name2");
			$id=mysql_result($result,$a,"id");
			echo"<option type='text' id='part' value='".$id."'>".$name1."</option>";
			}
			?>
			</select>
			<input class="submit" type="submit" name="submit2" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>SEARCH FOR PARTNERSHIP</h3>
		<form action="searchPartner.php" method="post" enctype="multipart/form-data">
			<label for="partner">By List:</label></br>
			<select type="text" name="partner" id="partner">
			<?php
			include("dbinfo.php");
			$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
			mysql_select_db($database) or die('Could not select database');
			$query = "SELECT  *FROM partnerships WHERE 1 ORDER BY name";
			$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
			$num = mysql_numrows($result);
			for($a=0;$a<$num;$a++)
			{
			$name1=mysql_result($result,$a,"name");
			$id=mysql_result($result,$a,"id");
			echo"<option type='text' id='partner' value='".$id."'>".$name1."</option>";
			}
			?>
			</select>
			<input class="submit" type="submit" name="submit2" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>SEARCH FOR MEETING</h3>
		<form action="searchMeeting.php" method="post" enctype="multipart/form-data">
			<label for="date">By Date:</label></br>
			<input type="date" name="date" id="date">
			<input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
		<form action="searchMeeting.php" method="post" enctype="multipart/form-data">
			<label for="date">By List:</label></br>
			<select type="date" name="date" id="date">
			<?php
			include("dbinfo.php");
			$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
			mysql_select_db($database) or die('Could not select database');
			$query = "SELECT  *FROM meetings WHERE 1 ORDER BY date_of_event DESC";
			$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
			$num = mysql_numrows($result);
			for($a=0;$a<$num;$a++)
			{
			$date=mysql_result($result,$a,"date_of_event");
			$id=mysql_result($result,$a,"id");
			echo"<option type='date' id='date' value='".$date."'>".$date."</option>";
			
			}
			?>
			</select>
			
			<input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>ADD FEEDBACK</h3>
		<form action="addFeedback.php" method="post" enctype="multipart/form-data">
		<label for="feedback1">Catagory: General Comments:</label></br>
		<textarea type="text" name="feedBack1" id="feedBack1" style='width:100%;height:100px'></textarea></br>
		<label for="feedback2">Catagory: Agenda items/topics</label></br>
		<textarea type="text" name="feedBack2" id="feedBack2" style='width:100%;height:100px'></textarea></br>
		<label for="feedback3">Catagory: Key points for SpeakUp</label></br>
		<textarea type="text" name="feedBack3" id="feedBack3" style='width:100%;height:100px'></textarea></br>
		<label for="feedback4">Catagory: Items to take forward</label></br>
		<textarea type="text" name="feedBack4" id="feedBack4" style='width:100%;height:100px'></textarea></br>
	<!--	<input type="hidden" name="catagory" id="catagory"value=1/>-->
		<label for="date">Meeting:</label></br>
			<select type="date" name="date" id="date">
			<?php
			include("dbinfo.php");
			$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
			mysql_select_db($database) or die('Could not select database');
			$query = "SELECT  *FROM meetings WHERE 1 ORDER BY date_of_event DESC";
			$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
			$num = mysql_numrows($result);
			for($a=0;$a<$num;$a++)
			{
			$date=mysql_result($result,$a,"date_of_event");
			$id=mysql_result($result,$a,"id");
			echo"<option type='date' id='date' value='".$date."'>".$date."</option>";
			
			}
			?>
			</select>
		<label for="name2">Member:</label></br>
		<select type="text" name="name2" id="name2">
		<?php
		include("dbinfo.php");
		$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
		mysql_select_db($database) or die('Could not select database');
		$query = "SELECT  *FROM members WHERE 1 ORDER BY name1";
		$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
		$num = mysql_numrows($result);
		for($a=0;$a<$num;$a++)
		{
			$name1=mysql_result($result,$a,"name1");
			$name2=mysql_result($result,$a,"name2");
			$id=mysql_result($result,$a,"id");
			echo"<option id='name2' value='".$id."'>".$name1."</option>";
			
		}
		?>
		</select>
		<label for="partner">Partnership:</label></br>
		<select type="text" name="partner" id="partner">
			<?php
			include("dbinfo.php");
			$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
			mysql_select_db($database) or die('Could not select database');
			$query = "SELECT  *FROM partnerships WHERE 1 ORDER BY name";
			$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
			$num = mysql_numrows($result);
			for($a=0;$a<$num;$a++)
			{
			$name1=mysql_result($result,$a,"name");
			$id=mysql_result($result,$a,"id");
			echo"<option type='text' id='partner' value='".$id."'>".$name1."</option>";
			}
			?>
			</select>
		</br>
		</br><input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>ADD MEMBER</h3>
		<form action="addMember.php" method="post" enctype="multipart/form-data">
		<label for="name1">Name:</label></br>
		<input type="text" name="name1" id="name1"/>
		<br>
		<label for="name2">Organisation:</label></br>
		<input type="text" name="name2" id="name2"/>
		<br>
		<label for="email">Email:</label></br>
		<input type="text" name="email" id="email"/>
		<br>
		<label for="date">Date Joined:</label></br>
		<input type="date" name="date" id="date"/>
		<br>
		<label for="comm">Communities:</label></br>
		<input type="text" name="comm" id="comm"/>
		<br>
		<br><input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>ADD PARTNERSHIP</h3>
		<form action="addPartner.php" method="post" enctype="multipart/form-data">
		<label for="name">Name:</label></br>
		<input type="text" name="name" id="name"/><br>
		<label for="date">Date Joined:</label></br>
		<input type="date" name="date" id="date"/>
		<label for="contact">Organiser:</label></br>
		<input type="text" name="contact" id="contact"/><br>
		<label for="org">Organisation:</label></br>
		<input type="text" name="org" id="org"/><br>
		<label for="email">Email:</label></br>
		<input type="text" name="email" id="email"/><br>
		<label for="tel">Telephone:</label></br>
		<input type="text" name="tel" id="tel"/><br>
		<br><input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<div>
		<h3>ADD MEETING</h3>
		<form action="addMeeting.php" method="post" enctype="multipart/form-data">
		<label for="date">Date held:</label></br>
		<input type="date" name="date" id="date"/><br>
		<label for="partner">Partnership:</label></br>
		<select type="text" name="partner" id="partner"><br>
		<?php
		include("dbinfo.php");
		$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
		mysql_select_db($database) or die('Could not select database');
		$query = "SELECT  *FROM partnerships WHERE 1 ORDER BY name";
		$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
		$num = mysql_numrows($result);
		for($a=0;$a<$num;$a++)
		{
			$name1=mysql_result($result,$a,"name");
			$id=mysql_result($result,$a,"id");
			echo"<option id='name2' value='".$id."'>".$name1."</option>";
			
		}
		mysql_close();
		?>
		</select>
		<br><input class="submit" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<div class='ochreDiv' id="footer">
		<p id='footerTxt'>Developed for 3VA by Samsara Graphic Solutions ©2018</p>
	</div>
	<script>
		function hover(state){
			if(state=="over"){document.getElementById("logOffBtn").src="assets/logOut_hover.png";}
			if(state=="out"){document.getElementById("logOffBtn").src="assets/logOut.png";}
		}
	</script>
	</body>
</html>