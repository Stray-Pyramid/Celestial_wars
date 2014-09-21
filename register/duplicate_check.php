<?php
	//Checks if a value is already present in the database.
	//Currently only available for username and password
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		die();
	}
	
	//Connect to database
	require_once '../../../../CW_Config/connect.php';
	
	//Get data to check
	if(isset($_POST['username'])){
		$data = trim($_POST['username']);
		$field = "username";
	}else{
		$data = trim($_POST['email']);
		$field = "email";
	}
	
	//Form SQL queries
	$query_scaf = "SELECT username FROM users WHERE %s LIKE '%s'";

	dbConnect($con);
	//For query and Escape strings
	$query = sprintf($query_scaf, $con->escape_string($field), $con->escape_string($data));
	//Query for submitted username
	$check = dbQuery($con, $query);

	//If username was found (0 < rows were returned), return false
	if($check->num_rows){
		echo "false";
	} else {
	//else return true.
		echo "true";
	}
	$check->free_result();
	exit();

?>