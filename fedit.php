<?php
	session_start();
	if(!isset($_SESSION['id2'])){var_dump($_SESSION['id']); header("Location:Homepage.php");}
	
	$con2=mysql_connect("localhost","root","");
	mysql_select_db("db2",$con2);
	
	$sql='SELECT FriendSno FROM friends WHERE UserSno='.$_SESSION['Sno'] ;
	$data=mysql_query($sql);
	echo '<form action="remove.php" name="remove" method="post">';
	while($rem=mysql_fetch_array($data)){
		$sql2='SELECT FirstName, LastName, Image from data WHERE Sno='.$rem['FriendSno'];
		$data2=mysql_query($sql2);
		$rem2=mysql_fetch_array($data2);
		echo '<img src="upload/'.$rem2['Image'].'" height=30 width=30>&nbsp'.$rem2['FirstName'].$rem2['LastName'].'<input type="checkbox" name="'.$rem['FriendSno'].'" value="'.$rem['FriendSno'].'"><br>';
	}
	echo '<input type="submit" value="Unsubscribe"></form>';
?>