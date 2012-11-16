<?php
	
	session_start();
	//For unsetting the Session ID
	session_unset();
	//For deleting the values of all the session variables
	session_destroy();
	//Deleting the cookie
	setcookie("PHPSESSID","", time() - 42000);
	header("Location:Homepage.php");
	
?>