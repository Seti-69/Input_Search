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
		<h2>SEARCH RESULTS</h2>
	</div>
	<?php
		echo "<div class='ochreDiv' style='height:30px;'>
		<a class='button' style='margin-top:4px;margin-left:-3px;position:absolute' href='index.php'>MAIN MENU</a>
		<a href='index_logIn.php' style='float:right' title='Log Out'>
		<img id='logOffBtn'onmouseover='hover(\"over\");' onmouseout='hover(\"out\");' style='margin-top:3px' src='assets/logOut.png' width='32px' height='32px' alt='logOut'></a>
		<p id='logInTxt'style='float:right;margin-top:5px;color:#d5d683'>Logged in: ".$name1."</p></div>";
	?>
<?php
include("dbinfo.php");
$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
	  mysql_select_db($database) or die('Could not select database');
$date = mysql_real_escape_string($_POST['date'], $db);
$query = "SELECT  *FROM meetings WHERE 1 ";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
$num = mysql_numrows($result);
$check=false;
$id;
$member="";
$count=0;
echo "<div><h3>MEETING</h3></div><div class='ochreDiv'>";
for($a=0;$a<$num;$a++)
{
	if(mysql_result($result,$a,"date_of_event")==$date){
		$check=true;
		echo"<p>Date:".$date."</p><p>Venue: ";
		$venue=mysql_result($result,$a,"venue");
		$id=mysql_result($result,$a,"id");
		echo $venue."</p></div>";
	}
}
if(!$check){
	echo"<p>No meeting exists on that date</p></div>";
}else{
	echo "<div><h3>FEEDBACK</h3></div>";
	$query = "SELECT  *FROM feedback_type01 WHERE 1 ";
	$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
	$num = mysql_numrows($result);
	for($a=0;$a<$num;$a++)
	{
	if(mysql_result($result,$a,"meeting_id")==$id){
		$count++;
		echo "<div class='ochreDiv'><p>".$count."- ".mysql_result($result,$a,'feedback')."</p>";
		$query2 = "SELECT  *FROM members WHERE 1 ";
		$result2 = mysql_query($query2) or die('Query1 failed: ' . mysql_error());
		$num2 = mysql_numrows($result2);
		for($b=0;$b<$num2;$b++){
			if(mysql_result($result2,$b,"id")==mysql_result($result,$a,'member_id')){
				$member=mysql_result($result2,$b,'name1')." ".mysql_result($result2,$b,'name2');
			}
		}
		
		echo "<p>Written by: ".$member."</p></div>";
	//	$query3 = "SELECT  *FROM meetings WHERE 1 ";
	//	$result3 = mysql_query($query3) or die('Query1 failed: ' . mysql_error()); ;
	//	$num3 = mysql_numrows($result3);
	//	for($c=0;$c<$num3;$c++){
	//		if(mysql_result($result,$a,"meeting_id")==mysql_result($result3,$c,'id')){
	//			$date=mysql_result($result3,$c,'date_of_event');
	//		}
	//	}
	//	echo "<p>Meeting on: ".$date."</p></br>";
		}
	}
	if($count<=0){echo "<div><p>No feedback exists for this meeting</p>";}
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