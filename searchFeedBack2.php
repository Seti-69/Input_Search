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
		<h2>SEARCH FEEDBACK</h2>
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
$word = mysql_real_escape_string($_POST['word'], $db);
$query = "SELECT  *FROM meetings WHERE 1 ";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
$num = mysql_numrows($result);
$matchFound=false;
$count=0;
$member="";
$date;
//if($word!=""){
	echo "<div><h2>Matches for: ' ".$word." '</h2></div>";
	$query = "SELECT  *FROM feedback_type01 WHERE 1 ";
	$result = mysql_query($query) or die('Query1 failed: ' . mysql_error());
	$num = mysql_numrows($result);
	for($a=0;$a<$num;$a++)
	{
		$chkEnd=false;									//Lists all feedback matches
		$fdbck=mysql_result($result,$a,"feedback");
		for($b=0;$b<strlen($fdbck);$b++){
			if(strtolower(substr($fdbck,$b,strlen($word)))==strtolower($word)&&$chkEnd==false){
				$count++;
				echo "<div class='ochreDiv'><h3>".$count."<p style='font-weight:bold'>".$fdbck."</p>";
				$chkEnd=true;
				$matchFound=true;
				$query2 = "SELECT  *FROM members WHERE 1 ";
				$result2 = mysql_query($query2) or die('Query1 failed: ' . mysql_error());
				$num2 = mysql_numrows($result2);
				for($b=0;$b<$num2;$b++){
					if(mysql_result($result2,$b,"id")==mysql_result($result,$a,'member_id')){
						$member=mysql_result($result2,$b,'name1');
					}
				}
				echo "<p style='font-weight:normal'>Written by: ".$member."</p>";
				$query3 = "SELECT  *FROM meetings WHERE 1 ";
				$result3 = mysql_query($query3) or die('Query1 failed: ' . mysql_error()); ;
				$num3 = mysql_numrows($result3);
				for($c=0;$c<$num3;$c++){
					if(mysql_result($result,$a,"meeting_id")==mysql_result($result3,$c,'id')){
						$date=mysql_result($result3,$c,'date_of_event');
					}
				}
				$cat=mysql_result($result,$a,'catagory');
				switch ($cat) {
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
				echo "<p style='font-weight:normal'>Meeting on: ".$date."</p>";
				echo "<p style='font-weight:normal'>Catagory: ".$cat2."</p></div>";
			}											// 
		}
		
		
		}
//}
	if($matchFound==false){echo "<div><h3>No matches found using: ".$word."</h3></div>";}
mysql_close();
?>

</br><a class="button" href='index.php'>MAIN MENU</a>
	<script>
		function hover(state){
			if(state=="over"){document.getElementById("logOffBtn").src="assets/logOut_hover.png";}
			if(state=="out"){document.getElementById("logOffBtn").src="assets/logOut.png";}
		}
	</script>
</body>
</html>