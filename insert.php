<?php
	
	
  session_start(); // For resuming the session.
  if(!isset($_SESSION['id'])) header("Location:Homepage.php"); // For Checking whether Session ID set or not , which is set on Homepage.php
 
  // Here Session variables are set according to the values received from form.html
  $_SESSION['login_email']=$_REQUEST['email'];
  $_SESSION['login_pass']=md5($_REQUEST['pwd1']);
  
  $con1=mysql_connect("localhost","root",""); // For connecting to mysql server
  if(!$con1){
     die('Sorry , could not connect'.mysql_error());
  }
  mysql_select_db("db2",$con1);
  
  
  //$imagedata = addslashes(file_get_contents("upload/".$new_name));
  
  //Server side check for checking whether all the fields were filled or not . Though it is not required as Browser sidee check has already been performed using JS 
  if(!isset($_POST['firstname'])||!isset($_POST['lastname'])||!isset($_POST['age'])||!isset($_POST['email'])||!isset($_POST['pwd1'])){
	die('Fill The Details First');
  }
  else{
  	$prevmax=mysql_query("SELECT MAX(Sno) as MAXIMUM FROM data");// Lines 25 -27 is the process for obtaining the Serial No. of the current user , which is needed for renaming the uploaded picture as Sno.<extension>
  	$prev_max=mysql_fetch_array($prevmax);
  	$cur_sno=$prev_max['MAXIMUM']+1;
  	if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) { 
		$insert_name="\"NoImage\"";
  	}
  
  	else{
		$temp=explode(".",$_FILES['file']['name']);
		$new_name=($cur_sno).'.'.end($temp);// The new name for the image is found using the current Sno with a .<extension> appended to it, which ensures a unique image name for each user as Sno is Primary Key.
		$insert_name="'".$new_name."'";
        }
  	// In the following sql command the password is inserted into the database after md5 encryption.
  	$sql="INSERT INTO data(FirstName,LastName,Age,EMAIL,Password,Image,Gender,City) VALUES ('$_POST[firstname]','$_POST[lastname]','$_POST[age]','$_POST[email]',md5('$_POST[pwd1]'),$insert_name,'$_POST[gender]','$_POST[city]')";
  	// Lines 39-45 are for checking whether the entered email already exists or not.
    	$echeck= mysql_query("SELECT EMAIL FROM data");
  	while($mail=mysql_fetch_array($echeck)){
    
    		if($mail['EMAIL']=="$_POST[email]"){ 
	   		die('Sorry Email already registered');
	 	} 
	} 
   
  	if('$_POST[firstname]'==null&&'$_POST[lastname]'==null&&'$_POST[age]'==null)// Redundant server side check for checking whether the fields are null or not.
     		die('Sorry, null values not allowed'.mysql_error());
  	else if(!mysql_query($sql))
	 	die('Sorry, Could not enter your data '.mysql_error());
  	else  
     		echo "Entry Successful.Congratulations!"."<br/><br/>";
  }
 //CODE FOR SELECTING AND DISPLAYING ALL THE DATA
/* 
  $result=mysql_query("SELECT * FROM data");
  while($row = mysql_fetch_array($result)){
     echo $row['Sno']." ".$row['FirstName']." ".$row['LastName']." ".$row['Age']." ".$row['EMAIL']." ".$row['Password']."<br/>" ;  
  	  }
*/
 
  // Lines 63-82 are for successfully uploading an image.
  $allowed=array("jpeg","gif","png","jpg");
  $temp=explode(".",$_FILES['file']['name']);
  $extension= end($temp);
  // If checks in lines 66 & 67 are to check whether the uploaded image is valid or not.
  if((($_FILES['file']['type']=="image/jpeg")||($_FILES['file']['type']=="image/pjpeg")||($_FILES['file']['type']=="image/gif"))&&in_array($extension,$allowed)&&($_FILES['file']['size']<5000000)){
	if ($_FILES["file"]["error"] > 0){
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}
	else{ // For displaying the information of the uploaded file.
			/*
			echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Stored in: " . $_FILES["file"]["tmp_name"]."<br>";
			echo "Stored in: "."upload/".$new_name;
			*/
		move_uploaded_file($_FILES['file']['tmp_name'],"upload/".$new_name);
		echo " Image Uploaded Successfully";
  
			
	}
  }
  else{
	echo 'Please upload a valid image';	
  }
  //Link for sending the user to the profile page. The Playground !
  echo '<br><a href="http://127.0.0.1/Test/profile.php">Go To Profile</a><br/>';
  mysql_close($con1);
  
?>  
