<?php
	/*The purpose of this script is to check if any structures have finished upgrading and if so,
	change their $is_upgrading to false, and increment the structure $level.
	In the future it will also update the amount of resources the user has including the difference in the rate of resources
	before and after the structure was upgraded.*/
	$user_id = 1;
	
	//Connect to database
	require_once '../../database_connection.php';
	//Run query for any structures that have finished upgrading
	$query = "SELECT structure_id, structure, level, upgrade_start, upgrade_duration FROM structure_status where user_id = 1 and is_upgrading = 1;";
	$result = array();
	$i = 0;
	
	$query_result = mysql_query($query);
	
	while($query_result = mysql_fetch_array($query_result)){	
		$result[$i]['structure_id'] = $query_result['structure_id'];
		$result[$i]['structure'] = $query_result['structure'];
		$result[$i]['level'] = $query_result['level'];
		$result[$i]['upgrade_start'] = $query_result['upgrade_start'];
		$result[$i]['upgrade_duration'] = $query_result['upgrade_duration'];
		$i++;
	}

	//(If the current time is greater than the $upgrading_start and $upgrading_duration combined)
	$i = 0;
	while(!empty($result[$i])){
		if((strtotime($result[$i]['upgrade_start']) + $result[$i]['upgrade_duration']) <= strtotime('now')){
			$result[$i]['is_upgrading'] = 0;
			$result[$i]['level']++;
			$result[$i]['upgrade_start'] = 0;
			$result[$i]['upgrade_duration'] = 0;
			$i++;
		} else {
			$result[$i]['is_upgrading'] = 1;
			$i++;
		}
	}
	
	//Send values back to DB

//Insert the user into the database
	$i = 0;
	while(!empty($result[$i]['structure_id'])){
		$insert_sql = "UPDATE structure_status SET is_upgrading='{$result[$i]['is_upgrading']}', level='{$result[$i]['level']}', upgrade_start='{$result[$i]['upgrade_start']}', upgrade_duration='{$result[$i]['upgrade_duration']}' WHERE structure_id={$result[$i]['structure_id']};";
		mysql_query($insert_sql)
			or die("Error entering data: " . mysql_error() . "<br>Got up to structure {$result[$i]['structure']}");
		$i++;
	}
	
?>