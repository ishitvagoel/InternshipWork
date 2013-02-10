<?php
	session_start();
	
	if(!isset($_SESSION['id2'])){
		var_dump($_SESSION['id']); 
		header("Location:Homepage.php");
	}
	
	$con2=mysql_connect("localhost","root","");
	mysql_select_db("db2",$con2);
	
	$sql='SELECT FriendSno FROM friends WHERE UserSno='.$_SESSION['Sno'] ;
	$data=mysql_query($sql);
	while($rem=mysql_fetch_array($data)){
		
		if(isset($_POST[$rem['FriendSno']])){
			$sql2='DELETE FROM friends WHERE UserSno='.$_SESSION['Sno'].' AND FriendSno='.$rem['FriendSno'].';';
			mysql_query($sql2);
		}
	}
	header("Location:fedit.php");
?>	
