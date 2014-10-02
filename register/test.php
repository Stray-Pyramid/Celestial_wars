<?php
	//Database function testing
	
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

	debug("Select ran");
	
	//Password testing
	$options = array('cost' => 11);
	$hash = password_hash("ustedb12", PASSWORD_BCRYPT, $options);
	
	echo $hash;
	echo '<br/>';
	if (password_verify('ustedb12', $hash)) {
		echo 'Password is valid!';
	} else {
		echo 'Invalid password.<br/>';
	}

	//Date format my sql
	echo date('Y-m-d H:I:s') . "<br>";

	//Can do $result->multiquery(); instead of using two queries, 
	//multiquery will present problems to single queries if all the results are not looped though. Possible way to discard query? 
	dbQuery($con, "CALL REGEXRUN(@a, 'james@banned.com');");
	$result = dbQuery($con, "SELECT @a;");
	$row = $result->fetch_assoc();
	if($row['@a'] == 1){
		echo "true";
	} else{
		echo "false";
	}
	dbClose($con);
?>