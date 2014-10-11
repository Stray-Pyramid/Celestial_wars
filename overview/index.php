<?php
//Overview

//IDEAS:
//if no planet is selected, list all available planets
//Could get planet id from GET, list only information that is available to the user_error
//If no planet id from GET, default to a list of owned planets? would void status box idea
//Could have a status / news box to update user on what has been happening recently

//Player clicks on planet link, takes to status screen with GET planet id
session_start();

//PROBLEM: User with only one planet will be redirected if that user wants to look at the overview

//Available session variables:
// id
// username

require_once '../../../../CW_Config/connect.php';

//authorize($_SESSION);
authorize($_SESSION);
dbConnect($con);

function displayPlanets($con, $planetResult = NULL){
	if($planetResult = NULL){
		//do query for planets owned by player
		$planetQuery = "SELECT `orbiting`,`type`,`x_pos`,`y_pos`,`res_coal`,`res_food`,`last_updated`,`universe` FROM planets WHERE owner = {$_SESSION['id']}";
		$planetResult = dbQuery($con, $planetQuery);
	}
	echo "<table>";
	while($result = $planetResult->fetch_array()){
		echo "<tr>";
		for($i = 0; $i > count($result); $i++){
			echo "<td>" . $result[$i] . "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}


function planetInProximity($x_pos, $y_pos, $con, $universe){
	$query = "SELECT `id` FROM planets WHERE universe = {$universe} AND x_pos BETWEEN " . $x_pos + 10 . " AND " . $x_pos - 10 . " OR y_pos BETWEEN " . $y_pos + 10 . " AND " . $y_pos - 10 . ";";
	$queryResult = dbQuery($con, $query);
	if($queryResult->numrows > 0){
		return true;
	} else {
		return false;
	}
}

function displayGalaxies($con){
	$galaxyQuery = "SELECT * FROM universes WHERE UNIX_TIMESTAMP() < finish_on;";
	$galaxyResponse = dbQuery($con, $galaxyQuery);
	echo "<h3>Please Select a galaxy to join</h3>";
	echo "<table>";
	while($results = $galaxyResponse->fetch_array(MYSQLI_NUM)){
		echo "<tr>";
		echo "<td><a href='?u=" . $results[0] . "'>Galaxy{$results[0]}</a></td>";
		print_r($results);
		foreach($results as $result){
			echo "<td>" . $result . "</td>";
		}
		echo "</tr>";
	}
	
	echo "</table>";
}

function generateStructure($structures, $player_id, $object_id){
	$strucQuery = "INSERT INTO structures (owner, planet, type, producing) VALUES (`%s`,`%s`,`%s`,`%s`)";
	foreach($structures as $structure){
			dbQuery($con, sprintf($strucQuery,
														$player_id,
														$object_id,
														$structure,
														0.5));
	
	}
}

$userQuery = "SELECT * FROM users WHERE id = {$_SESSION['id']}";
$user_result = dbQuery($con, $userQuery);
$result = $user_result->fetch_assoc();

$planetQuery = "SELECT `orbiting`,`type`,`x_pos`,`y_pos`,`res_coal`,`res_food`,`last_updated`,`universe` FROM planets WHERE owner = {$_SESSION['id']}";
$planet_result = dbQuery($con, $planetQuery);

If ($planet_result->num_rows == 0){
	if(isset($_GET['u']) && is_numeric($_GET['u']){
		//Check if selected world exists and if it has available slots 
		$i = 0;
		do{
			$x_cor = rand(-1000, 1000);
			$y_cor = rand(-1000, 1000);
			$i++;
			if($i == 100) echo "Could not generate planet, no space!";
		}while (planetInProximity($x_cor, $y_cor, $con, $u) || $i >= 100);
		
		$generatePlanetQuerySprintf = "INSERT INTO (universe, owner, type, last_updated, res_coal, res_iron, res_food, created_on, x_pos, y_pos)planets VALUES (`%s`,`%s`,`%s`,`%s`,`%s`,`%s`,`%s`,`%s`,`%s`)";
		$generatePlaetQuery = sprintf($generatePlanetQuerySprintf,
													$con->escape_string($_GET['u']),
													$_SESSION['id'],
													rand(0, 10),
													time('now'),
													50,
													50,
													50,
													date('Y-m-d H:i:s'),
													$x_cor,
													$y_cor);

		dbQuery($con, $query);
		$planetID = $con->insert_id;
		//Generate default structures for planet
		$structures = array('struc_coal', 'struc_iron', 'struc_food');
		generateStructures($structures, $_SESSION['id'], $planetID);
		
		dbClose($con);
		header("location: planet.php?p={$planetID}");
		die();
	} else {
		displayGalaxies($con);
	}
} elseif($planet_result->num_rows == 1){
	$planet = $planet_results->fetch_assoc();
	header("location: planet.php?p={$planet['id']}");
} else{
	displayPlanets($con, $planet_result);
}

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
		<p>Your are logged in as <?php echo $result['username'] . " with the id of " . $result['id']; ?></p>

		<p><?php echo $email_status; ?></p>
		<div id="content"><?php if(isset($content)) echo $content ?></div>
		<a href="../logout.php">Logout</a>
		<a href="../">Homepage</a>
		<?php footerDefault("Overview"); ?>
	</body>
</html>