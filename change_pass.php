<?php
	session_start();
	
	
	if(!isset($_SESSION['id2'])) header("Location:Homepage.php");
	echo '<html>
	      <head>
		  <script type="text/javascript">
		  function checkpass(){
			var p1=document.forms["pform"]["np"].value;
			var p2=document.forms["pform"]["cp"].value;
			var p=document.forms["pform"]["op"].value;
			var ps=0;
			if ((p==null||p=="")||(p1==null||p1=="")||(p2==null||p2==""))
				{
					alert("Please fill all the details");
					return false;
				}
			for(var l=0;l<p1.length;l++){
				if(p1.charAt(l)==" ") {ps++; break;}
			}
			if(ps!=0){
				alert("Sorry! Whitespaces are not allowed");
				return false;
			}
			var spcl_found=0;
			for(var i=33;i<=126;i++){
				if(((i<=47)||(i>=58&&i<=64)||(i>=91&&i<=96)||(i==126))&&(p1.indexOf(String.fromCharCode(i))>=0)){	
				spcl_found=1;
				break;
				}	
			}
			if(p1.length<5){
				alert("Password should be atleast 5 characters long");
				return false;
			}	
			if(spcl_found==0) {
				alert("Password must contain atleast one special character"); 
				return false;
			}
 
			if(p1!=p2){
				alert("Passwords do not match , Try again");
				return false;  
			}
			
		  }
		  </script>		  
		  </head>
		  <body>
		  <div style="text-align:center"><br><br><br><br><br><br><br><br><br><br><form action="change_pass.php" onsubmit="return checkpass()" name="pform" method="post">
	          Enter Old Password:&nbsp&nbsp<input type="password" name="op"><br><br>
		  Enter New Password:<input type="password" name="np"><br><br>
		  Confirm Password: &nbsp &nbsp<input type="password" name="cp"><br><br>
		  <input type="submit" value="Change is what we can believe in !"></div>
		  </body>
		  </html>';
	$con=mysql_connect("localhost","root","");
	if(!$con){
     		die('Sorry , could not connect'.mysql_error());
	}
	mysql_select_db("db2",$con);
	$data=mysql_query("SELECT Password FROM data WHERE Sno=".$_SESSION['Sno']);
	$pass=mysql_fetch_array($data);
	if(isset($_POST['op'])){	
		if(md5($_POST['op'])==$pass['Password']){
			mysql_query('UPDATE data SET Password='."'".md5($_POST['np'])."'".' WHERE Sno='.$_SESSION['Sno']);
			$_SESSION['login_pass']=md5($_POST['np']);
			echo '<h2>Password updated successfully </h2>';
			echo '<br><br><a href="http://127.0.0.1/Test/profile.php">Go Back to Profile</a>';
		}
		else{
			echo "Sorry the old Password is invalid";
		}
	}
	
?> 
