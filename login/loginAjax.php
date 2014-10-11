<?php

require_once '../../../../CW_Config/connect.php';

dbConnect($con);

if($_SERVER['REQUEST_METHOD'] == 'GET') header("location: ". SITE_ROOT);

function userBanned($user, $con){
	$ban_check = "SELECT * FROM banned_users WHERE user_id = {$user}";
	$unban_query = "DELETE FROM banned_users WHERE user_id = {$user}";
	$ban_query = dbQuery($con, $ban_check);
	if ($ban_query->num_rows > 0){
		$ban_result = $ban_query->fetch_assoc();
		if((strtotime("now") < $ban_result['ban_expires']) || $ban_result['ban_expires'] == 0){
			//User is still banned
			return TRUE;
		} else {
			//Users ban has expired, remove ban row and return
			dbQuery($con, $unban_query);
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function loginFail($con, $msg){
	dbClose($con);
	echo $msg;
	die();
}

if (isset($_POST['username']) || isset($_POST['password'])){
	//See if the username submitted matches any rows
	$user_query = "SELECT * FROM users WHERE username LIKE '" . $con->escape_string($_POST['username']) . "';";
	$user_queryResult = dbQuery($con, $user_query);
	$result = $user_queryResult->fetch_assoc();
	//Else, login failed.
	if(!$user_queryResult->num_rows > 0){
		loginFail($con, "Password Incorrect");
	}
	
	//Check the password. If not matching, login failed
	if(!password_verify($_POST['password'], $result['passhash'])){
		loginFail($con, "Password Incorrect");
	}
	
	//Check if user needs to validate their email
	if(EMAIL_VALIDATION && $result['must_validate'] == 1){
		//User still needs to register their account
		loginFail($con, "You need to validate you email. <a href='#'>Didn't receive one?</a>");
	}
		
	if(userBanned($result['id'], $con)){
		loginFail($con, "This user is banned. <a href='#'>Why?</a>");
	}
	
	echo "TRUE";
} else {
	echo "Please submit a username and password";
}
die();





?>