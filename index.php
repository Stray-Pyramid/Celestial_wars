<?php
//Frontpage!

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
			<button type="submit"  class="btnLogout" onclick="location.href='logout.php'" >Log out</button>
EOD;

} else {
	//show the page normally (with login)
	$loginBoxContents  = <<<EOD
<h3>Login</h3>

			<form id="login_form" action="login/" method="POST" name="loginForm">
				<input type="text" name="username" id="usernameInput" size="30" placeholder="username" />
				<input type="password" name="password" id="passwordInput" size="20" placeholder="password" />
				<input type="checkbox" name="remeberLogin" class="btnRemember" />
				<label for="rememberLogin">Remember me (TODO) </label>
				<input type="submit" id="loginSubmit" class="btnLogin" value="Sign in" />
				<img id='loadingGif' src='images/loading.gif' />
			</form>
			<div id="error" class="error"></div>
EOD;
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<?php headerDefault("Celestial Wars: A project by StrayPyramid"); ?>

		<link rel="stylesheet" type="text/css"  href="css/overviewStyle.css" />
		<script src="login/loginValidation.js" type="text/javascript"></script>
	</head>
	<body>
		<header>
			<img src="images/logo.png" alt="Celestial Wars Logo" />
			<h1>Celestial Wars</h1>
			<h2>A project by Stray Pyramid</h2>
		</header>
		<div class="content">
			<section class="boxLeft">
				<h3>Join Planet Wars today!</h3>
				<button type="submit"  class="btnRegister" onclick="location.href='register'" >Sign up now!</button>
			</section>
			<section id="login_section" class="boxRight">
				<?php echo $loginBoxContents; ?>
			
			</section>
			<section class="boxNews">
				<h3 class="objective">Current Objective:</h3>
				<ul>
					<li>List of planets</li>
					<li>Main planet Overview (20%)</li>
				</ul>
			</section>
		</div>
		<div class="footer">
		</div>
		<?php footerDefault(); ?> 
	</body>
</html>


