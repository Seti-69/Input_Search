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
		<h2>PARTNERSHIP FOUND</h2>
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
$partner = mysql_real_escape_string($_POST['partner'], $db);
$query = "SELECT  *FROM partnerships WHERE 1 ";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
$num = mysql_numrows($result);
$check=false;
$meetingid="";
for($a=0;$a<$num;$a++)
{
	if(mysql_result($result,$a,"id")==$partner){
		$check=true;
		echo"<h3 style='display:inline'>Partnership: </h3><p style='display:inline'>".mysql_result($result,$a,"name")."</p></br>";
		echo"<h3 style='display:inline'>Date Joined: </h3><p style='display:inline'>".mysql_result($result,$a,"date_created")."</p></br>";
		echo"<h3 style='display:inline'>Organiser: </h3><p style='display:inline'>".mysql_result($result,$a,"contact")."</p></br>";
		echo"<h3 style='display:inline'>Organisation: </h3><p style='display:inline'>".mysql_result($result,$a,"organisation")."</p></br>";
		echo"<h3 style='display:inline'>Email: </h3><p style='display:inline'>".mysql_result($result,$a,"email")."</p></br>";
		echo"<h3 style='display:inline'>Telephone: </h3><p style='display:inline'>".mysql_result($result,$a,"telephone")."</p></br>";
		
	}
}
if(!$check){
	echo"<h3>No meeting exists for the date: ".$date."</h3></br>";
}else{

}

?>
</div>
<!-- List all meetings and members for the partnership-->
<?php
$count=0;
echo "<div><h3>MEETINGS</h3></div>";
	$query = "SELECT  *FROM meetings WHERE 1 ORDER BY date_of_event DESC";
	$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
	$num = mysql_numrows($result);
	for($a=0;$a<$num;$a++)
	{
	if(mysql_result($result,$a,"partnership_involved")==$partner){
		$count++;
		echo "<div class='ochreDiv'><p>".$count."- ".mysql_result($result,$a,'date_of_event')."</p></div>";
		
		}
	}
	if($count<=0){echo "<div class='ochreDiv'><p>No meetings exits for this partnership</p></div>";}
	$memberList=array();
	$memberName=array();
$count=0;
echo "<div><h3>ASSOCIATED MEMBERS</h3></div>";
	$query2 = "SELECT  *FROM memb_partnr WHERE 1 ";
	$result2 = mysql_query($query2) or die('Query1 failed: ' . mysql_error());
	$num2 = mysql_numrows($result2);
	for($a=0;$a<$num2;$a++)
	{
		if(mysql_result($result2,$a,"partner")==$partner){
			$count++;
			$query4 = "SELECT  *FROM members WHERE 1 ORDER BY name1";
			$result4 = mysql_query($query4) or die('Query1 failed: ' . mysql_error());
			$num4 = mysql_numrows($result4);
			for($b=0;$b<$num4;$b++)
			{
				if(mysql_result($result4,$b,"id")==mysql_result($result2,$a,"member")){
					$name2=mysql_result($result4,$b,"name1");
					echo "<div class='ochreDiv'><p>".$count."- ".$name2."</p></div>";
					array_push($memberList,mysql_result($result4,$b,"id"));
					array_push($memberName,$name2);
				}
				
			}
		}
	
	}
	if($count<=0){echo "<div class='ochreDiv'><p>No members exists for this partnership</p></div>";}
	
	
	$count=0;
	//print_r ($memberList);
	//print_r ($memberName);
	echo "<div><h3>FEEDBACK</h3></div>";
	$query = "SELECT  *FROM feedback_type01 WHERE 1 ";
	$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
	$num = mysql_numrows($result);
	
		for($b=0;$b<$num;$b++){
			if(mysql_result($result,$b,"partnership")==$partner){
				$count++;
				echo "<div class='ochreDiv'><p style='font-weight:bold'>".$count."- ".mysql_result($result,$b,'feedback')."</p>";
				$query5 = "SELECT  *FROM members WHERE 1 ";
				$result5 = mysql_query($query5) or die('Query1 failed: ' . mysql_error()); ;
				$num5 = mysql_numrows($result5);
				for($c=0;$c<$num5;$c++){
					if(mysql_result($result5,$c,"id")==mysql_result($result,$b,'member_id')){
						$memberName[$a]=mysql_result($result5,$c,'name1');
					}
				}
				
				echo "<p>Written by: ".$memberName[$a]."</p>";
				$query3 = "SELECT  *FROM meetings WHERE 1 ";
				$result3 = mysql_query($query3) or die('Query1 failed: ' . mysql_error()); ;
				$num3 = mysql_numrows($result3);
				for($c=0;$c<$num3;$c++){
					if(mysql_result($result,$b,"meeting_id")==mysql_result($result3,$c,'id')){
						$date=mysql_result($result3,$c,'date_of_event');
					}
				}
				echo "<p style='font-weight:normal'>Meeting on: ".$date."</p>";
				switch (mysql_result($result,$b,'catagory')) {
					case 1:
					$cat2="General Comments";
					break;
					case 2:
					$cat2="Agenda items/topics";
					break;
					case 3:
					$cat2="Key points for SpeakUp";
					break;
					case 4:
					$cat2="Items to take forward";
					break;
				}
				echo "<p>Catagory: ".$cat2."</p></div>";
			}
		}
	
	if($count<=0){echo "<div class='ochreDiv'><p>No feedback exists for this partnership</p></div>";}
	mysql_close();
?>


<!---->


</br><a class="button" href='index.php'>MAIN MENU</a>
	<script>
		function hover(state){
			if(state=="over"){document.getElementById("logOffBtn").src="assets/logOut_hover.png";}
			if(state=="out"){document.getElementById("logOffBtn").src="assets/logOut.png";}
		}
	</script>
</body>
</html>
