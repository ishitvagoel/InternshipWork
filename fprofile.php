<?php
	session_start();
	if(!isset($_SESSION['id2'])) header("Location:Homepage.php");
	
	$con=mysql_connect("localhost","root","");
	mysql_select_db("db2",$con);
	
	$sql='SELECT FirstName,LastName,Age,EMAIL,Image,Gender,City,SUpdate FROM data WHERE Sno='.$_REQUEST['Sno'];
	$data=mysql_query($sql);
	$display=mysql_fetch_array($data);
	
	echo '<html><head></head><body>
		  <div style="float:left;text-align:left">
          <img src="upload/'.$display['Image'].'" alt="NO IMAGE" width="100" height="100" />&nbsp<b>'.$display['FirstName'].' '.$display['LastName'].'&nbsp&nbsp&nbsp&nbsp&nbsp STATUS :---->'.$display['SUpdate'].'<br><br>Age:&nbsp'.$display['Age']
		  .'<br><br>Email:&nbsp'.$display['EMAIL'].'<br><br>Gender:&nbsp'.$display['Gender'].'<br><br>City:&nbsp'.$display['City'].'</b>';
		  
		  
?>
          		  
	