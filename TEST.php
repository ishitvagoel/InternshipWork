<?php 
	$con=mysql_connect("localhost","root","");
	mysql_select_db("db2",$con);
	
	
	//echo '<form name"invisible" method="post"><input type="hidden" name="mail" value="'.$_REQUEST['login_email'].'">
		//  <input type="hidden" name="pass" value="'.$_REQUEST['pwd'].'">';
	$sql2="SELECT EMAIL FROM data";
	$emails=mysql_query($sql2);
	
	$found=0;
	for(;$email=mysql_fetch_array($emails);){
		if($email['EMAIL']==$_REQUEST['login_email']) { $found=1; break;}
	}	
	if($found==1){
		$sql="SELECT * FROM data WHERE EMAIL="."\"".$_REQUEST['login_email']."\"";
		$data=mysql_query($sql);
		$display=mysql_fetch_array($data);
	
		if((($display['Password']==md5($_REQUEST['login_pass']))||($display['Password']==$_REQUEST['pwd']))&&$display['Status']==1){
			echo '<html><head></head><body>
				<div style="float:left;text-align:center">';
			if($display['Image']=="NoImage"){
			echo '<img src="upload/default.jpg" alt="Default" width="100" height="100" /></td>';
			}
			else{
			echo '<img src="upload/'.$display['Image'].'" alt="NO IMAGE" width="100" height="100" /></td>';
			}	
			echo '</div>
				<div style="float:left"><b>Welcome <i>'.$display['FirstName'].'!</i><br>Nice To See You Here ! Howdy?<br><br><a href="http://127.0.0.1/Test/edit.php?esno='.$display['Sno'].'">Edit Information</a></b></div>
				<div style="text-align:center"><br><br><br><br><br><br>
                <br><h1><a href="http://127.0.0.1/Test/AngryBirds.php?Sno='.$display['Sno'].'">Play Angry Birds !</a> </h1>
				<h1><a href="http://127.0.0.1/Test/BMXPARK.php?Sno='.$display['Sno'].'">Play BMX Park !</a></h1>
                 </div><div style="float:right;text-align:left">People Like You:<br></div><div style="float:right">';
					
				$sq="SELECT Game From game AS recentgame Where Sno=".$display['Sno']."ORDER BY LastPlay DESC LIMIT 1";
			    mysql_query($sq);
				$sq2="SELECT Sno From game WHERE Game=recentgame";
				$snos=mysql_query($sq2);
				while($sno=mysql_fetch_array($snos)){
						
					if($sno['Sno']!=$display['Sno']){
						$sql_frnd="SELECT FirstName,LastName,Image FROM data where Sno=".$sno['Sno'];
						
						$frnd=mysql_query($sql_frnd);
						if($frnd){
							$frnd_info=mysql_fetch_array($frnd);
							echo '<img src="upload/'.$frnd_info['Image'].'" height=50 width=50>'." ".$frnd_info['FirstName']." ".$frnd_info['LastName'].'<br>'; 
						}
					}
				}	
					
				
	        	echo '</div>';
		}
		
		else if($display['Status']==0) echo 'You Have Been Deactivated By The Administrator :P';
		else echo "Invalid Login";
	}
	else echo 'ACCOUNT DOESN\'T EXIST<br><a href="http://127.0.0.1/Test/form.html">Sign Up </a>';

?>