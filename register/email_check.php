<?php
	//Checks if a email is already present in the database or is banned.

	//Connect to database
	require_once '../../../../CW_Config/connect.php';

	//Redirect if page is requested by the wrong method
	if($_SERVER['REQUEST_METHOD'] == 'GET') header('Location:' .SITE_404);
	
	
	//Get data to check
	$data = trim($_POST['email']);
	
	//Form SQL query
	$query_scaf 	= "SELECT email FROM users WHERE email LIKE '%s'";
	$procedure 	= "Call REGEXRUN(@a, '%s');";
	$get_data 	= "SELECT @a;";
	
	dbConnect($con);
	//For query and Escape strings
	$query = sprintf($query_scaf, $con->escape_string($data));
	//Query for submitted username
	$check = dbQuery($con, $query);

	//If username was found (0 < rows were returned), return false
	if($check->num_rows){
		echo "\"<img src='images/invalid.png'><p>This email already exists within the database</p>\"";
		dbClose($con);
		die();
	}
	$check->free_result();
	
		//For query and Escape strings
	$query = sprintf($procedure, $con->escape_string($data));
	//Query for email
	dbQuery($con, $query);
	$result = dbQuery($con, $get_data);
	
	$row = $result->fetch_assoc();
	if($row['@a'] == 1){
		echo "\"<img src='images/invalid.png'><p>This email is banned and not allowed to register</p>\"";
	} else{
		echo TRUE;
	}
	
	dbClose($con);
	exit();

?>