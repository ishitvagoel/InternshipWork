<?php
	session_start();//For resuming the Session
	
	//Following is the check whether these session variables are set or not, if they are not set then user needs to login or signup.
	if(!isset($_SESSION['login_email'])&&!isset($_SESSION['login_pass'])&&!isset($_REQUEST['login_email'])&&!isset($_REQUEST['login_pass'])) { echo ' Please Login or SignUp';exit();}
	if(!isset($_SESSION['id'])) header("Location:Homepage.php");
	
	//Following Line sets the session value at key id2 as 1 , this key must be set for all other pages in the website to open.
	$_SESSION['id2']=1;
	
	//if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==1)	;
	
	//Lines 13-17 check whether the session variables for login email and login pass are set or not(set on insert.php) , if they are not then the user has come via Homepage.php
	if(!isset($_SESSION['login_email'])&&!isset($_SESSION['login_pass'])){
		$_SESSION['login_email']=$_REQUEST['login_email'];
		$_SESSION['login_pass']=md5($_REQUEST['login_pass']);
	}	
	$con=mysql_connect("localhost","root","");
	mysql_select_db("db2",$con);
	
	//var_dump($_SESSION['login_email']);
	//echo '<form name"invisible" method="post"><input type="hidden" name="mail" value="'.$_REQUEST['login_email'].'">
		//  <input type="hidden" name="pass" value="'.$_REQUEST['pwd'].'">';
	
	//Lines 26-32 are for finding whether the entered email id exists in the database or not.
	$sql2="SELECT EMAIL FROM data";
	$emails=mysql_query($sql2);
	
	$found=0;
	for(;$email=mysql_fetch_array($emails);){
		if($email['EMAIL']==$_SESSION['login_email']) { $found=1; break;}
	}	
	if($found==1){ // If the entered email id is found to exist in the database then only its information will be displayed else the account doesn't exist.
		$sql="SELECT * FROM data WHERE EMAIL="."\"".$_SESSION['login_email']."\"";// This Query selects all the information about the user who is trying to login in.
		$data=mysql_query($sql);
		$display=mysql_fetch_array($data);
		$_SESSION['Sno']=$display['Sno'];
		$_SESSION['Password']=$display['Password'];
		$_SESSION['Gender']=$display['Gender'];
		$_SESSION['City']=$display['City'];
		
		// Following check matches the password extracted from the database with the md5 encryption of the user entered password 
		//and the status of the user attempting to login.The passwords should match and the status should be 1 for successful login.
		if($display['Password']==$_SESSION['login_pass']&&$display['Status']==1){
			echo '<html><head></head><body>
				<div style="float:left;text-align:center">';
			if($display['Image']=="NoImage"){
			echo '<img src="upload/default.jpg" alt="Default" width="100" height="100" /></td>';
			}
			else{
			echo '<img src="upload/'.$display['Image'].'" alt="NO IMAGE" width="100" height="100" /></td>';
			}	
			echo '</div>
				<div style="float:left"><b>Welcome <i>'.$display['FirstName'].'!</i><br>Nice To See You Here ! Howdy?<br>My Status:'.$display['SUpdate'].'<br><a href="http://127.0.0.1/Test/edit.php">Edit Information</a><br>
				<a href="http://127.0.0.1/Test/logout.php">Logout</a></b></div>
				<div style="text-align:center"><br><br><form action="status.php" name="status" method="post"><input type="text" value="Enter Status" name="status"><input type="submit" value="Submit"></form><br><br><br><br>
                <br><h1><a href="http://127.0.0.1/Test/AngryBirds.php">Play Angry Birds !</a> </h1>
				<h1><a href="http://127.0.0.1/Test/BMXPARK.php">Play BMX Park !</a></h1>
                 </div><div style="float:right;text-align:left">People You May Like :<br></div><div style="float:right"><form name="friend" action="friends.php" method="post">';
					
				//Lines 62-110 are used for generation of friend suggestions , and for allowing user to subscribe others.
					//Two methods to generate friend suggetions are used.
						//1) On the basis of opposite gender
						//2) On the basis of last common played game
				
				//The following check selects the appropriate SQL command for selecting the Snos of possible friends on the basis of gender.
				if($display['Gender']=='male'){
					$sql_g='SELECT Sno FROM data WHERE Gender="female" and Sno Not In (Select FriendSno from friends Where UserSno='.$_SESSION['Sno'].')';
				}
				else $sql_g='SELECT Sno FROM data WHERE Gender="male" and Sno Not In (Select FriendSno from friends Where UserSno='.$_SESSION['Sno'].')';
				
				$opp=mysql_query($sql_g);
				$j=0;
				//This While loop creates an array of Snos of all the possible friends on the basis of gender.
				while($person=mysql_fetch_array($opp)){
					$selected_g[$j]=$person['Sno'];
					$j++;
				}
				//The following check is done to know that the array contains atleast one element,otherwise the array is empty.
				if(isset($selected_g[0])){
					$a=$selected_g[array_rand($selected_g)];// array_rand() function selects a random "KEY" of an array.
					$sql_p='SELECT FirstName,LastName,Image,Status,Image FROM data where Sno='.$a;
					$pers_g=mysql_query($sql_p);
					$pers=mysql_fetch_array($pers_g);
					echo '<img src="upload/'.$pers['Image'].'" height=50 width=50>'." ".$pers['FirstName']." ".$pers['LastName'].'<input type="checkbox" name="frnd1" value='.$a.'><br><br>';
				}
				
				//The following SQL statement selects the last game which the logged on user played.
				$sq="SELECT Game From game Where Sno="."\"".$display['Sno']."\""." ORDER BY LastPlay DESC LIMIT 1";
			    $lastgame=mysql_query($sq);				
				$last=mysql_fetch_array($lastgame);
				
				//the following query selects the Sno of all those users who played the game which was last played by the logged on user.
				if($last){
					$sq2='SELECT Sno From game WHERE Game='."\"".$last['Game'].'"and Sno Not In (Select FriendSno from friends Where UserSno='.$_SESSION['Sno'].')';
					
					$snos=mysql_query($sq2);
					$i=0;
				
					while($sno=mysql_fetch_array($snos)){
						$selected[$i]=$sno['Sno'];
						$i++;
					}
				
				
					$s=$selected[array_rand($selected)];
					if($s!=$display['Sno']){
						
						$sql_frnd="SELECT FirstName,LastName,Image,Status FROM data where Sno=".$s;
						$frnd=mysql_query($sql_frnd);
						
						if($frnd){
							$frnd_info=mysql_fetch_array($frnd);
							echo '<img src="upload/'.$frnd_info['Image'].'" height=50 width=50>'." ".$frnd_info['FirstName']." ".$frnd_info['LastName'].'<input type="checkbox" name="frnd2" value='.$s.'><br>'; 
						}
					}
					
				}
				echo '<br><br><input type="submit" value="Subscribe !"></div><div style="text-align:left"><b>My Subscriptions :</b><br><br>';
			
			$sql_friends="Select FriendSno From friends WHERE UserSno=".$_SESSION['Sno'];
			
			$myfrnds=mysql_query($sql_friends);
			while($myfrnd=mysql_fetch_array($myfrnds)){
					
					$sqlf='SELECT FirstName,LastName,Image,SUpdate FROM data WHERE Sno='.$myfrnd['FriendSno'];
					$frnd_data=mysql_query($sqlf);
					$frnd_d=mysql_fetch_array($frnd_data);
					//The following statement generates a link for the profile page for each subscription , by sending the Sno in thr URL.
					echo '<a href="http://127.0.0.1/Test/fprofile.php?Sno='.$myfrnd['FriendSno'].'"><img src="upload/'.$frnd_d['Image'].'" height=50 width=50>'." ".$frnd_d['FirstName']." ".$frnd_d['LastName'].'</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$frnd_d['SUpdate'].'<br>';
			}
			echo '<a href="http://127.0.0.1/Test/fedit.php">Edit Subscriptions</a></div>';	
		}
		//If the Status of a particular user is 0 then he gets deactivated and cannot login anymore.
		else if($display['Status']==0){ echo 'You Have Been Deactivated By The Administrator.';session_unset();session_destroy();}
		else { echo "Invalid Login"; session_unset(); session_destroy();}
	}
	else { echo 'ACCOUNT DOESN\'T EXIST<br><a href="http://127.0.0.1/Test/form.html">Sign Up </a>'; session_destroy();Session_unset();}

?>