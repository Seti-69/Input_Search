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
	<div style="text-align:center;background-color:#008131"   id="header">
		<h2>ADD FEEDBACK</h2>
	</div>
	<?php
		echo "<div class='ochreDiv' style='height:30px;'>
		<a class='button' style='margin-top:4px;margin-left:-3px;position:absolute' href='index.php'>MAIN MENU</a>
		<a href='index_logIn.php' style='float:right' title='Log Out'>
		<img id='logOffBtn'onmouseover='hover(\"over\");' onmouseout='hover(\"out\");' style='margin-top:3px' src='assets/logOut.png' width='32px' height='32px' alt='logOut'></a>
		<p id='logInTxt'style='float:right;margin-top:5px;color:#d5d683'>Logged in: ".$name1."</p></div>";
	?>
	<div>
<?php
include("dbinfo.php");
$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
	  mysql_select_db($database) or die('Could not select database');
$date = mysql_real_escape_string($_POST['date'], $db);  
$name2 = mysql_real_escape_string($_POST['name2'], $db);
$cat = 1;
$feedback1 = mysql_real_escape_string($_POST['feedBack1'], $db);
$feedback2 = mysql_real_escape_string($_POST['feedBack2'], $db);
$feedback3 = mysql_real_escape_string($_POST['feedBack3'], $db);
$feedback4 = mysql_real_escape_string($_POST['feedBack4'], $db);
$partner= mysql_real_escape_string($_POST['partner'], $db);
$query = "SELECT  *FROM members WHERE 1 ";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
$num = mysql_numrows($result);
$check1=false;
$check2=false;
for($a=0;$a<$num;$a++)
{
	if(mysql_result($result,$a,"id")==$name2){
		$id1=mysql_result($result,$a,"id");
		$check1=true;
		echo"<br><h3 style='display:inline'>Member: </h3><p style='display:inline'>".mysql_result($result,$a,'name1')."</p></br>";
	}
}
if(!$check1){echo"<p>No member exists of that name.</p>";}
$query = "SELECT  *FROM meetings WHERE 1 ";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
$num = mysql_numrows($result);
for($a=0;$a<$num;$a++)
{
	if(mysql_result($result,$a,"date_of_event")==$date){
		$id2=mysql_result($result,$a,"id");
		$check2=true;
		echo"<h3 style='display:inline'>Meeting: </h3><p style='display:inline'>".$date."</p></br>";
	}
}
if(!$check2){echo"<p>No meeting exists on that date.</p>";}
//switch ($cat) {
//    case 1:
//        $cat2="General Comments";
//        break;
//    case 2:
//        $cat2="Agenda items/topics";
//        break;
//    case 3:
//        $cat2="Key points for SpeakUp";
//        break;
//	case 4:
//        $cat2="Items to take forward";
//        break;
//}
$partner2="";
$query2 = "SELECT  *FROM partnerships WHERE 1";
			$result2 = mysql_query($query2) or die('Query1 failed: ' . mysql_error()); ;
			$num2 = mysql_numrows($result2);
			for($a=0;$a<$num2;$a++)
			{
			
			if(mysql_result($result2,$a,"id")==$partner){
				$partner2=mysql_result($result2,$a,"name");
				}
			}
//echo "<h3 style='display:inline'>Catagory: </h3><p style='display:inline'>".$cat2."</p></br>";
echo "<h3 style='display:inline'>Partnership: </h3><p style='display:inline'>".$partner2."</p>";
if($check1&&$check2){
	$query = "SELECT  *FROM feedback_type01 WHERE 1 ";
	$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
	$num3 = mysql_numrows($result);
	//echo $num3;
	$num=mysql_result($result,$num3-1,"ID");
	$feedback =array($feedback1,$feedback2,$feedback3,$feedback4);
	$b=0;
	for($a=1;$a<5;$a++){
		if($feedback[$b]!=""){
			$num++;
			$query="INSERT  INTO feedback_type01 VALUES ('$num','$id2','$id1','$feedback[$b]','$a','$partner')";
			$result=mysql_query($query) or die('Query2 failed: ' . mysql_error());
			
			}
			$b++;
		}	
	if ($result>0){
		
		}
	if($feedback[0]==""&&$feedback[1]==""&&$feedback[2]==""&&$feedback[4]==""){
		echo"<h3>No feedback was added.</h3>";}
		else{echo "<h3>Feedback added successfully: </h3><p></p>";}
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