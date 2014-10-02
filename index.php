<?php
//Frontpage!

//Page will follow one and two halfs style

//PHP Session Hijack prevention best practices:

//Full site https - Prevents MITM Attacks
//Store session in cookie only - Avoids leakage through a referrer
//Forbid access to cookie from javascript - Avoids XSS Vulnerabilities
//Include user agent string in session data - Prevents access by another browser, but can be easily spoofed.
//And if I am really paranoid, include the IP address of the user. If it changes, invalidate session.

//These steps will not protect the user from:
//Someone standing behind them and copying the session id, while the user is looking their the cookies.
//Spyware, Malware, things out of my control
//An attacker 'Mirroring' a users computer

//I care about my users security, and I will do my best so that they are safe while browsing my websites.
//Although, no matter how much security I put in place, an attacker still can punch through if they are determined.
//It is what plan I have after that matters the most.


//WAS MAKING REDIRECT FUNCTION, COULD NOT DECIDE ON ITS PROPER PURPOSE
session_start();

require_once '../../../CW_Config/connect.php';

if (isset($_SESSION['user_id'])){
	//show log out instead of log in forum;
	$loginBox_contents = <<<EOD
			<h3>You are logged in as</h3>
			<h3>{$_SESSION['username']}</h3>
			<a href="overview">Go to your overview</a>
			<a href="logout">Log out</a>
EOD;

} elseif (isset($_POST['username']) && isset($_POST['password'])){
	//See if the username submitted matches any rows
	//Else, login failed.
	if($result->num_rows > 0){
		//Check the password, if not matching, login failed
		if(!password_verify($_POST['password'], $passhash){
			$_SESSION['loginError'] = "We could not find an account with the username and password combination you provided.";
			header("login");
			dbClose($con);
		}
		//
		if(EMAIL_VALIDATION && $results['must_validate'] == 1){
			if({
				//User still needs to register their account
				$_SESSION['needValidate'] == TRUE;
				header("register/verification");
				dbClose($con);
				die();
			}
		}
		
		//Set session variables (id, user agent string)
		$_SESSION['ID'] = $result['id'];
		
		//Redirect to planet overview
		header("overview");
		
	} else {
		redirect("login", "We could not find an account with the username and password combination you provided.", $con);
	}
	
} else {
	//show the page normally (with login)
	$loginBox_contents  = <<<EOD
			<h3>Login</h3>
			<form id="login_form" action="" method="POST">
				<label for="username">Username:</label>
				<input type="text" name="username" id="usrname_input" size="30" placeholder="username" />
				<label for="password">Password:</label>
				<input type="password" name="password" id="pswrd_input" size="20" placeholder="password" />
				<input type="submit" value="Sign in" />
			</form>
EOD;
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Celestial Wars: A project by Stray Pyramid</title>
		<link rel="stylesheet" type="text/css"  href="css/root_style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		<img src="images/logo.png" alt="Celestial Wars Logo" />
		<h1>Celestial Wars</h1>
		<h2>A project by Stray Pyramid</h2>
		<section>
			<h3>Join Planet Wars today!</h3>
			<button type="submit"  onclick="location.href='register'" >Sign up now!</button>
		</section>
		<section id="login_section">
			<?php echo $loginBox_Contents; ?>
		</section>
		<h3 class="objective">Current Objective:</h3>
		<ul>
			<li>User Account System:</li>
			<li>Login and Logout</li>
			<li>Main planet Overview</li>
		</ul>
</html>


