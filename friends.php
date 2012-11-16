<?php
	session_start();
	if(!isset($_SESSION['id2'])) header("Location:Homepage.php");
	
	$con=mysql_connect("localhost","root","");
	mysql_select_db("db2",$con);
	
	if(isset($_POST['frnd1'])){
		$sql= 'INSERT INTO friends (UserSno,FriendSno) VALUES ('.$_SESSION['Sno'].','.$_POST['frnd1'].')' ;
		echo $sql;
		mysql_query($sql);
	}
	if(isset($_POST['frnd2'])){
		$sql2='INSERT INTO friends (UserSno,FriendSno) VALUES ('.$_SESSION['Sno'].','.$_POST['frnd2'].')' ;
		mysql_query($sql2);
	}
	header("Location:profile.php");
	?>