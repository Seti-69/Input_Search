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
	
	mysql_close();
	?>
	<body>
	<div style="text-align:center;background-color:#008131"  id="header">
		<h2>ATTENDANCE</h2>
	</div>
	<?php
		echo "<div class='ochreDiv' style='height:30px;'>
		<a class='button' style='margin-top:4px;margin-left:-3px;position:absolute' href='index.php'>MAIN MENU</a>
		<a href='index_logIn.php' style='float:right' title='Log Out'>
		<img id='logOffBtn'onmouseover='hover(\"over\");' onmouseout='hover(\"out\");' style='margin-top:3px' src='assets/logOut.png' width='32px' height='32px' alt='logOut'></a>
		<p id='logInTxt'style='float:right;margin-top:5px;color:#d5d683'>Logged in: ".$name1."</p></div>";
	?>
		<div class="">
<?php
include("dbinfo.php");
$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
	  mysql_select_db($database) or die('Could not select database');
$meeting = mysql_real_escape_string($_POST['meeting'], $db);
$query = "SELECT  *FROM meetings WHERE 1 ORDER BY date_of_event DESC";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
$num = mysql_numrows($result);
$check=false;
$partner="";
$meetingid="";
for($b=0;$b<$num;$b++){
			if(mysql_result($result,$b,"id")==$meeting){
				$date=mysql_result($result,$b,"date_of_event");
			}
		}
for($a=0;$a<$num;$a++)
{
	if(mysql_result($result,$a,"date_of_event")==$date){
		$check=true;
		echo"<h3 style='display:inline'>MEETING DATE: </h3><p style='display:inline'>".$date."</p></br>";
		//echo"<h3>VENUE: </h3><p>".mysql_result($result,$a,'venue')."</p>";
		$meetingid=mysql_result($result,$a,'id');
		$query2 = "SELECT  *FROM partnerships WHERE 1 ";
		$result2 = mysql_query($query2) or die('Query1 failed: ' . mysql_error()); ;
		$num2 = mysql_numrows($result2);
		for($b=0;$b<$num2;$b++){
			if(mysql_result($result,$a,"partnership_involved")==mysql_result($result2,$b,"id")){
				$partner=mysql_result($result2,$b,"name");
			}
		}
		echo"<h3 style='display:inline'>PARTNERSHIP INVOLVED: </h3><p style='display:inline'>".$partner."</p>";
	}
}
if(!$check){
	echo"<h3>No meeting exists for the date: ".$date."</h3></br>";
}else{

}

?>
</div>
<?php
include("dbinfo.php");
$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
	  mysql_select_db($database) or die('Could not select database');

$query = "SELECT  *FROM memb_mting WHERE 1 ";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
$num = mysql_numrows($result);
$check=false;
for($a=0;$a<$num;$a++)
{
		if(mysql_result($result,$a,"meeting")==$meeting){
			$memb=mysql_result($result,$a,"member");
			$query2 = "SELECT  *FROM members WHERE 1 ";
			$result2 = mysql_query($query2) or die('Query1 failed: ' . mysql_error());
			$num2 = mysql_numrows($result2);
			for($c=0;$c<$num2;$c++){
				if(mysql_result($result2,$c,"id")==$memb){
					$memb2=mysql_result($result2,$c,"name1");
					echo"<div class='ochreDiv'><h3 style='display:inline'>Member Name: </h3><p style='display:inline'>".mysql_result($result2,$c,'name1')."
					</br><h3 style='display:inline'>Organisation: </h3><p style='display:inline'>".mysql_result($result2,$c,'name2')."</p></br>";
					echo"<h3 style='display:inline'>Email: </h3><p style='display:inline'>".mysql_result($result2,$c,'email')."</p></br>";
					echo"<h3 style='display:inline'>Date Joined: </h3><p style='display:inline'>".mysql_result($result2,$c,'date_joined')."</p></div>";
					$check=true;
				}
			}
			
			
		}
}
if(!$check){
	echo"<div class='ochreDiv'><h3>No members attended this meeting.</h3></div>";
}else{

}
mysql_close();
?>
</div>
</br><a class="button" href='index.php'>MAIN MENU</a>
	<script>
		function hover(state){
			if(state=="over"){document.getElementById("logOffBtn").src="assets/logOut_hover.png";}
			if(state=="out"){document.getElementById("logOffBtn").src="assets/logOut.png";}
		}
	</script>
</body>
</html>