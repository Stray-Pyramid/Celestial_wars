<?php
session_start();

function login($username, $password)
	$username = mysql_real_escape_string(trim($_POST['username']));
	$password = mysql_real_escape_string(trim($_POST['password']));
	
	debug($username);
	
	$query = "SELECT user_id, username, FROM users WHERE username LIKE '%s'";
	
	grab_row(sprintf($query, $username), $results);
	
	if(mysqli_num_rows($results) == 1){
		
	//Logged in successfully
		debug("Login Succeded");
		header("Location: /overview/");
	} else {
		
		debug("Login failed");
		$error_msg = "The Username and Password combination was invalid."
		
	}
	
	

	
?>