<?php
	session_start();
	
	if(!isset($_SESSION['id2'])){
		var_dump($_SESSION['id']); header("Location:Homepage.php");
	}
	
	$con=mysql_connect("localhost","root","");
	
	mysql_select_db("db2",$con);
	
	$sql='UPDATE data SET SUpdate="'.$_REQUEST['status'].'" WHERE Sno='.$_SESSION['Sno'] ;
	
	mysql_query($sql);
	mysql_close($con);
	header("Location:profile.php");
?>
