<?php 
	
	session_start();
	$_SESSION['id']=session_id();
	echo '<html><head></head><body>
		  <div style="background-color:yellow;font-weight=bold;border-color:green; border-style:solid">
		  <marquee><h1>Welcome! &nbsp&nbsp&nbsp&nbsp&nbsp:)</h1></marquee>
		  </div>
		  <div style="background-color:orange;font-weight=bold;text-align:center;border-color:green; border-style:solid;text-decoration:blink">
		  <h2>Life is Awesome !</h2>
		  </div>
		  
		  <div style="text-align:center;"><h3>Login</h3><br>
		  <form name="login_form" action="profile.php" method="post">
		  Email:    &nbsp&nbsp&nbsp&nbsp   <input type="text" name="login_email" ><br><br>
		  Password:<input type="password" name="login_pass"><br><br><br><br>
		  <input type="submit" value="Here I Come !">
		  <br>
		  <br>
		  <br>
		  <br><br><br><br>
		  <h3>Don\'t Have An Account ?</h3><br>
		  <a href="http://127.0.0.1/Test/form.html">Sign Up </a>
		  </div><div style="float:left"><img src="upload/animated-gifs-smileys-235.gif"></div>';
		  
		  
?>
