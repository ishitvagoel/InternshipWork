<?php
	
	
	
	session_start();
	if(!isset($_SESSION['id2'])){var_dump($_SESSION['id']); header("Location:Homepage.php");}
	echo '<html>
			<head></head>
			<body>
			<div style="background-color:yellow;text-align:center"><script src="//www.gmodules.com/ig/ifr?url=http://www.forumforyou.it/google_gadget_angry_birds.xml&amp;synd=open&amp;w=820&amp;h=680&amp;title=Angry+Birds&amp;border=%23ffffff%7C0px%2C1px+solid+%23ffdd00%7C0px%2C2px+solid+%23ffdd33%7C0px%2C2px+solid+%23ffee99&amp;output=js"></script>
			</div>
			</body>
		  </html>';
	$angry="Angry.txt";
	
	$file=explode(' ',file_get_contents($angry));
	if(!in_array($_SESSION['Sno'],$file)){	
		$open= fopen($angry,"a");
		fputs($open,$_SESSION['Sno'].' ');
		fclose($open);
    }
    $con=mysql_connect("localhost","root","");
	
	mysql_select_db("db2",$con);
	$sql="UPDATE data SET Angry=1 WHERE Sno=".$_SESSION['Sno'];
	mysql_query($sql);
	
	$sql_game=('INSERT INTO game(Sno,Game) VALUES ('.$_SESSION['Sno'].',"Angry")');
	
	mysql_query($sql_game);
	
	mysql_close($con);


?>	