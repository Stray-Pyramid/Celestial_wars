<?php
//Overview

//IDEAS:
//if no planet is selected, list all available planets
//Could get planet id from GET, list only information that is available to the user_error
//If no planet id from GET, default to a list of owned planets? would void status box idea
//Could have a status / news box to update user on what has been happening recently

//Player clicks on planet link, takes to status screen with GET planet id

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Overview</title>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>
	<body>
		<h2>This is the overview.</h2>
		<p>Your are logged in as <?php echo $ID; ?></p>
		<p><?php echo $email_status; ?></p>
		<p><?php //list available planets;?>List of planets you own goes here.</p>
		<a href="//logout.php">Logout</a>
	</body>
</html>