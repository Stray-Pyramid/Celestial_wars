<?php

//1. Bad Username
//2. Bad Password
//3. Email validation still needed
//4. Account is banned

session_start();
require_once '../../../../CW_Config/connect.php';

dbConnect($con);


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
	$_SESSION['error'] = $msg;
	dbClose($con);
	return;
}

if (isset($_POST['username']) || isset($_POST['password'])){
	//See if the username submitted matches any rows
	$user_query = "SELECT * FROM users WHERE username LIKE '" . $con->escape_string($_POST['username']) . "';";
	$user_queryResult = dbQuery($con, $user_query);
	$result = $user_queryResult->fetch_assoc();
	//Else, login failed.
	if(!$user_queryResult->num_rows > 0){
		loginFail($con, "Did not find the requested Username / Password combination.");
	}
	
	//Check the password. If not matching, login failed
	if(!password_verify($_POST['password'], $result['passhash'])){
		loginFail($con, "Did not find a the requested Username / Password combination.");
	}
	
	//Check if user needs to validate their email
	if(EMAIL_VALIDATION && $result['must_validate'] == 1){
		//User still needs to register their account
		loginFail($con, "You need to validate you email. <a href='#'>Didn't receive one?</a>");
	}
		
	if(userBanned($result['id'], $con)){
		loginFail($con, "This user is banned.");
	}
		
	//Set session variables (id, user agent string)
	$_SESSION['id'] = $result['id'];
	$_SESSION['username'] = $result['username'];
		
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
	  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	
	$update_query = sprintf("UPDATE `users` SET `last_login_date`='%s', `last_login_ip`='%s' WHERE `id`='%s';",
										$con->escape_string(date('Y-m-d H:i:s')),
										$con->escape_string(ip2long($_SERVER['REMOTE_ADDR'])),
										$con->escape_string($result['id']));

	dbQuery($con, $update_query);
	
	//Redirect to planet overview
	header("Location: ../overview/");
		

	
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<?php headerDefault("Login"); ?>
	</head>
	<body>
		<h1>Celestial Wars</h1>
		<h3>Login</h3>
		<div class="error"><?php if(isset($_SESSION['error'])) echo $_SESSION['error']; ?></div>
		<form id="login_form" action="" method="POST">
			<label for="username">Username:</label>
			<input type="text" name="username" id="usrname_input" size="30" placeholder="username" <?php if(isset($_POST['username'])) echo $_POST['username']; ?> />
			<label for="password">Password:</label>
			<input type="password" name="password" id="pswrd_input" size="20" placeholder="password" />
			<input type="submit" value="Sign in" />
		</form>
	</body>
</html>
<?php
	if(isset($_SESSION['error'])) unset($_SESSION['error']);
	die();
?>