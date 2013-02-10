<?php
//if(session_id()=="") header("Location:Homepage.php");

session_start();
if(!isset($_SESSION['id2'])) header("Location:Homepage.php");
//if(!isset($_SESSION['id'])){echo "HI"; header("Location:Homepage.php");}
echo '<html><head> <script type="text/javascript">
function validateForm(){

	var x=document.forms["show"][0].value;
	var y=document.forms["show"][1].value;
	var z=document.forms["show"][2].value;

	var xs=0,ys=0,zs=0,es=0;

 
	if ((x==null||x=="")||(y==null||y=="")||(z==null||z==""))  {
  		alert("Please fill all the details");
  		return false;
  	}
  
	for(var l=0;l<x.length;l++){
    		if(x.charAt(l)==" ") {xs++; break;}
	}
	for(l=0;l<y.length;l++){
 		 if(y.charAt(l)==" ") {ys++; break;}
	}
	for(l=0;l<z.length;l++){
  		if(z.charAt(l)==" ") {zs++; break;}
	 }
  
 
	if(xs!=0||ys!=0||zs!=0){
  		alert("Sorry! Whitespaces are not allowed");
  		return false;
	}  


	if(isNaN(z)==true){
  		alert("Age must a valid number. Try Again");
  		return false;
	}

}
</script></head>';

	
	
   $con3=mysql_connect("localhost","root","");
   if(!$con3) die('Could Not Connect'.mysql_error());

		
		
   mysql_select_db("db2",$con3);
    /*if(!isset($_REQUEST['ep'])){ // the condition !isset($_REQUEST['esno'])&& was removed from if here.    
        echo '<form name="isno" action="edit.php" method="post">
        <input type="hidden" name="esno" value='.$_REQUEST['esno'].'>
		Please Enter Your Password:<input type="password" name="ep">
		<input type="submit"><br><br><br>
		</form>';
    } */   
   if(isset($_SESSION['Sno'])){
		
		$pass_res=mysql_query("SELECT Password FROM data WHERE Sno=".$_SESSION['Sno']);
		$pass=mysql_fetch_array($pass_res);
		if($_SESSION['Password']==$pass['Password']){
			$sql='SELECT * FROM data WHERE Sno='.$_SESSION['Sno'];
			$sql2='SELECT * FROM DATA ';
   
			$data=mysql_query($sql);
			$data2=mysql_query($sql2);
			
			$row=mysql_fetch_array($data);
   
			echo '<div style="text-align:center"><br><br><br><br><br><br><br><form name="show" action="edit.php" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
				First Name: <input type="text" name="0" value="'.$row['FirstName'].'"><br><br>
				Last Name:&nbsp<input type="text" name="1" value="'.$row['LastName'].'"><br><br>
				Age:   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="2" value="'.$row['Age'].'"><br><br>
				
				<label for="5">Upload Picture:</label><br><br>
				<input type="file" name="5" id="5" /> 
				<input type="hidden" name="4" value="'.$row['Sno'].'" >
				
				<input type="submit">
				</form></div>';
			if(isset($_FILES[5]['tmp_name'])&&file_exists($_FILES[5]['tmp_name'])){
			  
				$name = $_FILES[5]['name'];
				$temp = explode(".",$name);
				$new_name=($row['Sno']).'.'.end($temp);
				$insert_name="'".$new_name."'";
			   	$sql3='UPDATE data SET Image='.$insert_name.'WHERE Sno='.$row['Sno'] ;
				$allowed=array("jpeg","gif","png","jpg");
			
            			$extension= end($temp);
            			if((($_FILES[5]['type']=="image/jpeg")||($_FILES[5]['type']=="image/pjpeg")||($_FILES[5]['type']=="image/gif"))&&in_array($extension,$allowed)&&($_FILES[5]['size']<5000000)){
					if ($_FILES[5]["error"] > 0){
						echo "Error: " . $_FILES[5]["error"] . "<br />";
					}
					else{
						/*echo "Upload: " . $_FILES[5]["name"] . "<br />";
						echo "Type: " . $_FILES[5]["type"] . "<br />";
						echo "Size: " . ($_FILES[5]["size"] / 1024) . " Kb<br />";
						echo "Stored in: " . $_FILES[5]["tmp_name"]."<br>";
					
						echo "Stored in: "."upload/".$new_name;
						*/
						move_uploaded_file($_FILES[5]['tmp_name'],"upload/".$new_name);
						echo "Image Uploaded Successfully";
                    			mysql_query($sql3);
			        
				}
			}
			else{
				echo 'Please upload a valid image';	
			}
			
		}	
			$count=0;
			if(isset($_POST[0])&&isset($_POST[1])&&isset($_POST[2])&&isset($_POST[4])){
			    $sql_u='UPDATE data SET FirstName="'.$_POST[0].'",LastName="'.$_POST[1].'",Age="'.$_POST[2].'" WHERE Sno='.$_POST[4];
			    if($count!=1) mysql_query($sql_u);
			}
        }
		else echo"Password is Incorrect";	
		echo '<div style="text-align:center"><a href="http://127.0.0.1/Test/change_pass.php">Click Here To Change Password</a></div>';
	}
	echo '</html>';		
	
			
	
?>		 
         		 
