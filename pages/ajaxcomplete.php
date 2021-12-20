<?php
	$q=$_GET['q'];
	$my_data=$q;
	$conn=mysql_connect('localhost','root','') or die("Database Error");
	mysql_select_db('sampledb',$conn);
	$sql="SELECT * FROM product WHERE name LIKE '%$my_data%' ORDER BY id LIMIT 10";
	$result = mysql_query($sql) or die(mysql_error());
	
	if($result)
	{
		while($row=mysql_fetch_array($result))
		{
			echo $row['name']."\n";
		}
	}
?>