<?php
	require_once '../../../../CW_Config/connect.php';

	$sql_st = "SELECT * FROM `users` WHERE `id` = 1";
	
	dbConnect($con);
	$result = dbQuery($con, $sql_st);
	
	echo "<p>";
	while($row = $result->fetch_assoc()){
		print_r ($row);

	}
	echo "</p>";
	$result->free_result();

	
	$sql_st = "SELECT `id`,`username` FROM `users` ORDER BY `id`;";
	$result = dbQuery($con, $sql_st);

	echo "<p>";
	while($row = $result->fetch_assoc()){
		 print_r ($row);
		 echo "<br/>";
	}
	echo "</p>";
	dbClose($con);
	debug("Select ran");
?>