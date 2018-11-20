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
		<h2>SEARCH MEMBERS</h2>
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
$member = mysql_real_escape_string($_POST['memb'], $db);
$query = "SELECT  *FROM members WHERE 1 ORDER BY name1";
$result = mysql_query($query) or die('Query1 failed: ' . mysql_error()); ;
$num = mysql_numrows($result);
$check=false;
$strLngth=strlen($member);
echo "<div><h2>Searching Members by: ' ".$member." '</h2></div>";
for($a=0;$a<$num;$a++)
{
		if($num>0){
			$chckEnd=false;
			$fdbck=mysql_result($result,$a,"name1").mysql_result($result,$a,"name2");
			for($b=0;$b<strlen($fdbck);$b++){
				if(strtolower(substr($fdbck,$b,strlen($member)))==strtolower($member)&&$chckEnd==false){
					$check=true;
					$chckEnd=true;
					echo"<form method='post' action='searchMembers.php' enctype='multipart/form-data'>";
					echo"<input style='display:none' type='text' name='memb' id='memb' value='".mysql_result($result,$a,'id')."'/>";
					echo"<div class='ochreDiv'></br><h3 style='display:inline' >Name: </h3><p style='display:inline'>".mysql_result($result,$a,'name1')."</p></br>";
					echo "<h3 style='display:inline'>Organisation: </h3><p style='display:inline'>".mysql_result($result,$a,'name2')."</p></br>
					<input class='submit' type='submit' name='submit' value='Select'/></div></form>";
				
				}
			}
		}else{$chckEnd=true;$check=false;}
}
if(!$check){
	echo"<div class='ochreDiv'><h3>No members exist</h3></div>";
}else{

}
mysql_close();
?>

</br>
</body>
	<script>
		function hover(state){
			if(state=="over"){document.getElementById("logOffBtn").src="assets/logOut_hover.png";}
			if(state=="out"){document.getElementById("logOffBtn").src="assets/logOut.png";}
		}
	</script>
</html>