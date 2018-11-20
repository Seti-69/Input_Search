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
		<h2>MEETING</h2>
	</div>
	<?php
		echo "<div class='ochreDiv' style='height:30px;'>
		<a class='button' style='margin-top:4px;margin-left:-3px;position:absolute' href='index.php'>MAIN MENU</a>
		<a href='index_logIn.php' style='float:right' title='Log Out'>
		<img id='logOffBtn'onmouseover='hover(\"over\");' onmouseout='hover(\"out\");' style='margin-top:3px' src='assets/logOut.png' width='32px' height='32px' alt='logOut'></a>
		<p id='logInTxt'style='float:right;margin-top:5px;color:#d5d683'>Logged in: ".$name1."</p></div>";
	?>
	<div class="ochreDiv">
<?php
include("dbinfo.php");
$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
	  mysql_select_db($database) or die('Could not select database');
$date = mysql_real_escape_string($_POST['date'], $db);
$query = "SELECT  *FROM meetings WHERE 1 ORDER BY date_of_event DESC";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
$num = mysql_numrows($result);
$check=false;
$partner="";
$meetingid="";
for($a=0;$a<$num;$a++)
{
	if(mysql_result($result,$a,"date_of_event")==$date){
		$check=true;
		echo"<h3>MEETING DATE: </h3><p>".$date."</p>";
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
		echo"<h3>PARTNERSHIP INVOLVED: </h3><p>".$partner."</p>";
	}
}
if(!$check){
	echo"<h3>No meeting exists for the date: ".$date."</h3></br>";
	$meetingid="none";
}else{

}

?>
</div>
<!-- List all feedback for the meeting-->
<?php
$id=$meetingid;
$count=0;
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
				$member=mysql_result($result2,$b,'name1')."</br>".mysql_result($result2,$b,'name2');
			}
		}
		$cat2="";
		$cat=mysql_result($result,$a,'catagory');
		switch ($cat){
			case 1:$cat2="General Comments";
			break;
			case 2:$cat2="Agenda items/topics";
			break;
			case 3:$cat2="Key points for SpeakUp";
			break;
			case 4:$cat2="Items to take forward";
			break;
		}
		echo "<p>Written by: ".$member."</p><p>Catagory: ".$cat2."</p></div>";
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
	if($count<=0){echo "<div class='ochreDiv'><p>No feedback exists for this meeting</p></div>";}


?>


<!---->
<div>
		<p>FIND MEMBERS WHO ATTENDED THIS MEETING</p>
		<form action="searchMembers3.php" method="post" enctype="multipart/form-data">
		<?php
		echo "<input style='display:none' type='text' name='meeting' value='".$meetingid."'/>";
			?>
			<input class="submit" type="submit" name="submit" value="SEARCH"/>
		</form>
</div>
<div>
		<p>ADD MEMBER AS ATTENDED</p>
		<form action="linkMeeting.php" method="post" enctype="multipart/form-data">
		<?php
		echo "<input style='display:none' type='text' name='meeting' value='".$meetingid."'/>";
			?>
		<label for="memb">By List:</label></br>
		<select type="text" name="memb" id="memb">
			<?php
			//
			//include("dbinfo.php");
			//$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
			//mysql_select_db($database) or die('Could not select database');
			$query = "SELECT  *FROM members WHERE 1 ORDER BY name1";
			$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
			$num = mysql_numrows($result);
			for($a=0;$a<$num;$a++)
			{
			$name1=mysql_result($result,$a,"name1");
			$name2=mysql_result($result,$a,"name2");
			$id=mysql_result($result,$a,"id");
			echo"<option type='text' id='memb' value='".$id."'>".$name1."</option>";
			}
			
			mysql_close();
			?>
			</select>
			<input class="submit" type="submit" name="submit" value="ADD"/>
		</form>
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
