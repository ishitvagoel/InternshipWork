<?php

	session_start(); 
	if(!isset($_SESSION['id2'])){var_dump($_SESSION['id']); header("Location:Homepage.php");}
	echo'<html>
		<head></head>
		<body>
		<div style="background-color:yellow;text-align:center"><script type="text/javascript" src="http://cdn.widgetserver.com/syndication/subscriber/InsertWidget.js"></script><script type="text/javascript">if (WIDGETBOX) WIDGETBOX.renderWidget('.'"06c1929d-e74d-4b7d-81ee-659f91dfe6a8"'.');</script>


		</div>
		</body>
		</html>';
	$bmx="BMX.txt";
	$file=explode(' ',file_get_contents($bmx));
	if(!in_array($_SESSION['Sno'],$file)){	
		$open= fopen($bmx,"a");
		fputs($open,$_SESSION['Sno'].' ');
		fclose($open);
    }
	$con=mysql_connect("localhost","root","");
	
	mysql_select_db("db2",$con);
	$sql="UPDATE data SET BMX=1 WHERE Sno=".$_SESSION['Sno'];
	mysql_query($sql);
	$sql_game=('INSERT INTO game(Sno,Game) VALUES ('.$_SESSION['Sno'].',"BMX")');
	
	mysql_query($sql_game);
	
	mysql_close($con);

?>	