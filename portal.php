<?php
 $con=mysql_connect("localhost","root","");
 if(!$con){
      die('Could Not Connect'.mysql_error());
 }  
   
  mysql_select_db("db2",$con);
  
  
  $data=mysql_query("SELECT * FROM data");
  
  
  echo '<form name="CHANGE" action="portal.php" method="post">';
  echo " <table border='1'>
  <tr>
    <th>Sno.</th>
	<th>Diplay Picture</th>
	<th>FirstName</th>
	<th>LastName</th>
	<th>Age</th>
	<th>EMAIL</th>
	<th>Status</th>
	<th>Activate</th>
	<th>Deactivate</th>
  </tr> ";
   
   while($row=mysql_fetch_array($data)){
    
	echo "<tr>";
        echo "<td>".$row['Sno']."</td>";
        
	if($row['Image']=="NoImage"){
		echo '<td><img src="upload/default.jpg" alt="Default" width="100" height="100" /></td>';
	}
	else{
		echo '<td><img src="upload/'.$row['Image'].'" alt="NO IMAGE" width="100" height="100" /></td>';
	}
	
        echo "<td>".$row['FirstName']."</td>";
	echo "<td>".$row['LastName']."</td>";
	echo "<td>".$row['Age']."</td>";
	echo "<td>".$row['EMAIL']."</td>";
	echo "<td>".$row['Status']."</td>";
	//If the Active radio button is selected then status of the user becomes 1 or else if Deactivate radio button is selected, status becomes 0
	echo "<td><input type='radio' name=".$row['Sno']." value='a'></td>";
	echo "<td><input type='radio' name=".$row['Sno']." value='d'></td>";
	
	echo"</tr>";
	
   }
   echo'<input type="submit" />';
   echo"</form>";
   echo"</table>";
   $data=mysql_query("SELECT * FROM data");   
   
   for(;$beg=mysql_fetch_array($data);){
   	if(isset($_POST[$beg['Sno']])) {
   		
   		$sql_a= "UPDATE data SET Status=1 WHERE Sno=".$beg['Sno'];
   		$sql_d= "UPDATE data SET Status=0 WHERE Sno=".$beg['Sno'];
   		
   		if($_POST[$beg['Sno']]=='a')mysql_query($sql_a);
		if($_POST[$beg['Sno']]=='d')mysql_query($sql_d);
	}
   }
   ?>
