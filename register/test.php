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
	dbClose($con);
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

//foreach in $_POST
print_r($_POST);
?>