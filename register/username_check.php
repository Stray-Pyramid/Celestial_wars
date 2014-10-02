<?php
	//Checks if a username is already present in the database.

	//Connect to database
	require_once '../../../../CW_Config/connect.php';

	//Redirect if page is requested by the wrong method
	if($_SERVER['REQUEST_METHOD'] == 'GET') header('Location:' .SITE_404);
	
	//Get data to check
	$data = trim($_POST['username']);

	//Form SQL query
	$query_scaf = "SELECT username FROM users WHERE username LIKE '%s'";

	dbConnect($con);
	//For query and Escape strings
	$query = sprintf($query_scaf, $con->escape_string($data));
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