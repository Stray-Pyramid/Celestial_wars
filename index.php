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

session_start();

require_once '../../../CW_Config/connect.php';

if (isset($_SESSION['id'])){
	//show log out instead of log in forum;
	$loginBoxContents = <<<EOD
			<h3>You are logged in as</h3>
			<h3>{$_SESSION['username']}</h3>
			<a href="overview">Go to your overview</a>
			<a href="logout.php">Log out</a>
EOD;

} else {
	//show the page normally (with login)
	$loginBoxContents  = <<<EOD
			<h3>Login</h3>
			<form id="login_form" action="login" method="POST">
				<label for="username">Username:</label>
				<input type="text" name="username" id="usernameInput" size="30" placeholder="username" />
				<label for="password">Password:</label>
				<input type="password" name="password" id="passwordInput" size="20" placeholder="password" />
				<input type="submit" id="loginSubmit" value="Sign in" />
			</form>
EOD;
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<?php headerDefault("Celestial Wars: A project by StrayPyramid"); ?>

		<link rel="stylesheet" type="text/css"  href="css/root_style.css" />
		<script src="login/loginValidation.js" type="text/javascript"></script>
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
			<?php echo $loginBoxContents; ?>
		</section>
		<h3 class="objective">Current Objective:</h3>
		<ul>
			<li>Login and Logout (80%)</li>
			<li>Main planet Overview (20%)</li>
		</ul>
	</body>
	<?php footerDefault(); ?> 
</html>


