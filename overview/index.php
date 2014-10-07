<?php
//Overview

//IDEAS:
//if no planet is selected, list all available planets
//Could get planet id from GET, list only information that is available to the user_error
//If no planet id from GET, default to a list of owned planets? would void status box idea
//Could have a status / news box to update user on what has been happening recently

//Player clicks on planet link, takes to status screen with GET planet id
session_start();

require_once '../../../../CW_Config/connect.php';

authorize($_SESSION);
dbConnect($con);

$query = "SELECT * FROM users WHERE id = {$_SESSION['id']}";
$query_result = dbQuery($con, $query);
$result = $query_result->fetch_assoc();

if($result['must_validate']){
	$email_status = "You still need to verify your email address. (TODO)";
} else {
	$email_status = "You have successfully validated your email address. Congratulations!";
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<?php headerDefault("Overview"); ?>
	</head>
	<body>
		<h2>This is the overview.</h2>
		<p>Your are logged in as <?php echo $result['id']; ?></p>
		<p><?php echo $email_status; ?></p>
		<p><?php //list available planets;?>List of planets you own goes here.</p>
		<a href="../logout.php">Logout</a>
	</body>
	<?php footerDefault("Overview"); ?>
</html>