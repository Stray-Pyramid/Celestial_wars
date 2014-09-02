<?php
/*session_start();

require_once '../../app_config/app_config.php';
require_once 'php_util/login.php';

$username = $_POST['username'];

if (!isset($_SESSION['user_id']){
	//show log out instead of log in forum;
	debug("No session['user_id'] found");
	$loginBox_contents = <<<EOD
			<h3>You are logged in as</h3>
			<h3>{$_SESSION['username']}</h3>
			<a href="/overview">Go to your overview</a>
			<a href="/logout">Log out</a>
EOD;

} elseif (log in box was submitted){
	//try to log the user in
	debug("POST username was found");
	login();
*/
/*} else {
	//show the page normally (with login)
	$loginBox_contents  = <<<EOD
			<h3>Login</h3>
			<form id="login_form" action="" method="POST">
				<label for="username">Username:</label>
				<input type="text" name="username" id="usrname_input" size="30" <?php if(isset($username)) echo "value='{$username}' ";?> />
				<label for="password">Password:</label>
				<input type="password" name="password" id="pswrd_input" size="20" />
				<input type="submit" value="Sign in" />
			</form>
EOD;
}
*/	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Planet Wars</title>
		<link rel="stylesheet" type="text/stylesheet"  href="css/main_style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		<h1>Planet Wars</h1>
		<h2>A project by Stray Pyramid</h2>
		<section>
			<h3>Join Planet Wars today!</h3>
			<button type="submit"  onclick="location.href='signup.php'" >Sign up now!</button>
		</section>
		<section id="login_section">
			<?php echo $loginBox_Contents; ?>
		</section>
		<p class="objective">Current Objective:<br/>User Account System</p>
</html>

