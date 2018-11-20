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
//	if(!$_SESSION['lginData1'] && !$_SESSION['lginData2']){
//		$page='index_logIn.php';
//		header('Location:'.$page);
//		}
//	$name1= $_SESSION['lginData1'];
//	$id=$_SESSION['lginData2'];
//	include("dbinfo.php");
//	$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
 //   mysql_select_db($database) or die('Could not select database');
	
//	mysql_close();
	?>
	<body>
	<div style="text-align:center;background-color:#008131"  id="header">
		<h2>SPEAK UP DATABASE CONTROL PANEL</h2>
	</div>
	
	<div>
<?php
include("dbinfo.php");
$db = mysql_connect('localhost',$username,$password) or die('Could not connect: ' . mysql_error()); 
	  mysql_select_db($database) or die('Could not select database');
$name1 = mysql_real_escape_string($_POST['usr'], $db); 
$name2 = mysql_real_escape_string($_POST['key'], $db); 
$result2=0;
if($name1=="" || $name2==""){
	echo "<h3>Empty Fields.</h3></div></br><a class='button' href='index_logIn.php'>Log In</a>";

}else{$query = "SELECT  *FROM staff WHERE 1 ";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error()); ;
	$num = mysql_numrows($result);
	for($a=0;$a<$num;$a++)
	{
		if($name1==mysql_result($result,$a,"user") && $name2==mysql_result($result,$a,"key"))
		{
			$result2=1;
			$_SESSION['lginData1']=$name1;
			$_SESSION['lginData2']=$name2;
		}
	}
	if ($result2==1){
		echo "<h3>Log In Successful: </h3><p>Hello ".$name1."</p>
		</div></br><a class='button' href='index.php'>Continue</a>";
		}else{
			echo "<h3>Log In Failed: </h3><p>".$name1.",".$name2."</p>".
			"</div></br><a class='button' href='index_logIn.php'>Log In</a>";
		}
	}
mysql_close();


?>
</div>
</body>
</html>