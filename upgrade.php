<!DOCTYPE html>
<html>
	<head>
		<title>Upgrade Script</title>
		<meta http-equiv="refresh" content="1;url=index.php"> 
	</head>
	<body>
<?php

	require_once '../../database_connection.php';
		
	//Resource Requirement
	$coal_req = 50;
	$iron_req = 50;
	$food_req = 50;
	$upgrade_duration = 100;
	
	$user_id = "1";
	$structure = $_REQUEST['building'];
	
	if (!$structure){
		exit("<p>You must select a structure to upgrade!</p>");
	}
	
	$player_status = mysql_fetch_array(mysql_query("SELECT * FROM player_status WHERE user_id='{$user_id}'"));
	$structure_level = mysql_fetch_array(mysql_query("SELECT level,is_upgrading FROM structure_status WHERE structure='{$structure}' AND user_id='{$user_id}'"));

	if ($player_status == 0 or $structure_level == 0){ //Check if record for structure exists in DB
		die("Problem retrieving data from Database. Please contact support immeditaly.");
	}
	
	if ($structure_level[1]){  //Check if already upgrading
		die ("<p>Structure is already upgrading!</p>");
	} else {
		if($player_status['res_coal'] >= $coal_req and $player_status['res_iron'] >= $iron_req and $player_status['res_food'] >= $food_req){  	//Check Resources
			//Subtract Resources
			//Initialize upgrade
				
				//Upgrade duration x $level
			
			//Form SQL
			$time = date('Y-m-d H:i:s');
			$insert_sql = "UPDATE structure_status SET is_upgrading='1',upgrade_start='{$time}',upgrade_duration='{$upgrade_duration}' WHERE structure='{$structure}' AND user_id='{$user_id}';";
			//Send to DB
			mysql_query($insert_sql)
				or die("<p>Error starting upgrade: " . mysql_error() ."</p>");
			echo "<p>Your {$structure} is upgrading!</p>";
		} else {
			die ("<p>You do not have enough resources to upgrade your {$structure}!</p>"); 
		}
	}
	echo "script is working";
?>
	</body>
</html>