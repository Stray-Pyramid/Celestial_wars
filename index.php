<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		require_once '../../database_connection.php';
		require_once 'item_updater.php';
	
		$player_query = mysql_query("SELECT * FROM player_status WHERE user_id=1");
		$player = mysql_fetch_array($player_query);
		
		$struc_query = mysql_query("SELECT * FROM structure_status WHERE user_id = 1 ORDER BY field(structure, 'Mine_Coal', 'Mine_Iron', 'Farm_Bio', 'Powerplant_Uranium')");
		$i=0;
		$struc = array();

		while($struc_result = mysql_fetch_array($struc_query)){
			$struc[$i]['level']=$struc_result['level'];
			$struc[$i]['producing']=$struc_result['producing'];
			$struc[$i]['upkeep']=$struc_result['upkeep'];
			$struc[$i]['is_upgrading']=$struc_result['is_upgrading'];
			$struc[$i]['upgrade_start']=$struc_result['upgrade_start'];
			$struc[$i]['upgrade_duration']=$struc_result['upgrade_duration'];
			$i++;
		}
	?>

	<title>A typical MO Space strategy game</title>
	
	<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
	<link href="css/main.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
	
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
	
	<?php
	echo "var coal = " .  ($player['res_coal'] + ((strtotime('now') - strtotime($player['last_updated'])) * $struc[0]['producing'])) . ";";
	echo "var coal_inc = " . $struc[0]['producing'] / 4 . ";"; 
	echo "var iron = " . ($player['res_iron'] + ((strtotime('now') - strtotime($player['last_updated'])) * $struc[1]['producing'])). ";";
	echo "var iron_inc = " . $struc[1]['producing'] / 4  . ";"; 
	echo "var food = " . ($player['res_food'] + ((strtotime('now') - strtotime($player['last_updated'])) * $struc[2]['producing'])) . ";";
	echo "var food_inc = " . $struc[2]['producing'] / 4  . ";";
	?>
	
	$('#res_coal').html(coal);
	$('#res_iron').html(iron);
	$('#res_food').html(food);

	setInterval(function() {
		 var value = parseInt($('#res_coal').html());
		 coal = coal + coal_inc;
		 $('#res_coal').html(Math.ceil(coal));
	}, 250);

	setInterval(function() {
		 var value = parseInt($('#res_iron').html());
		 iron = iron + iron_inc;
		 var iron_round = Math.ceil(iron);
		 $('#res_iron').html(Math.ceil(iron));
	}, 250);

	setInterval(function() {
		 var value = parseInt($('#res_food').html());
		 food = food + food_inc;
		 $('#res_food').html(Math.ceil(food));
	}, 250);
	</script>
	
</head>
<body>
	<header>
		<div class="title">
		</div>
		<nav>
			<ul>
				<li><a href="#">Overview</a></li>
				<li><a href="#">Base Structures</a></li>
				<li><a href="#">Shipyard</a></li>
				<li><a href="#">Space Map</a></li>
				<li><a href="#">Space Map</a></li>
				<li><a href="#">Research</a></li>
			</ul>
		</nav>
	</header>
	<div class="main-content">
		<div class="resources">
			<ul>
				<li><img src="images/coal_icon.png"><span id="res_coal"></span></li>
				<li><img src="images/iron_icon.png"><span id="res_iron"></span></li>
				<li><img src="images/food_icon.png"><span id="res_food"></span></li>
				<li><img src="images/elec_icon.png"><?php echo $player['res_elec']?></li>
			</ul>
		</div>
		<div class="structure">
			<div class="structure_pic">
				<h3>Coal Mine</h3>
				<img src="images/Mine_Coal.png" alt="Coal Mine"/>
			</div>
			<div class="progress_bar" id="Mine_Coal">
				<div class="percent"></div>
				<div class="pbar"></div>
				<div class="elapsed"></div>
				<?php
					if ($struc[0]['is_upgrading']){
						//Get time to finish and start progress bar
						$current_progress = 0;
						$time_to_finish = $struc[0]['upgrade_duration'] - (strtotime('now') - strtotime($struc[0]['upgrade_start']));
						echo "<script type='text/javascript'>progress_bar({$time_to_finish}, Mine_Coal);</script>";//Add '$time till finish' script
					} else /*If not upgrading*/{
						//Echo the level of the structure and its resource rate
						echo "<p>LEVEL {$struc[0]['level']}</p>";
						echo "<p>Producing 0.5 tons of coal per second.<p>";
					}
				?>
			</div>
			<div class="upgrade_button">
				<?php
					if($struc[0]['is_upgrading']){
					//If Upgrading
					echo "<p>Structure is upgrading!</p>";
					} else {//If not upgrading
					echo "<form action='upgrade.php' method='POST'>
						<input type='hidden' name='building' value='Mine_Coal' />
						<input type='submit' value='Upgrade'>
					</form>";
					}
				?>
			</div>
		</div>

		<div class="structure">
			<div class="structure_pic">
				<h3>Iron Mine</h3>
				<img src="images/Mine_Iron.png" alt="Iron Mine"/>
			</div>
			<div class="progress_bar" id="Mine_Iron">
				<div class="percent"></div>
				<div class="pbar"></div>
				<div class="elapsed"></div>
				
				<script type='text/javascript'>progress_bar(500, Mine_Iron);</script>
			</div>
			<div class="upgrade_button">
			
				<form action="upgrade.php" method="POST">
					<input type="hidden" name="building" value="Mine_Iron" />
					<input type="submit" value="Upgrade">
				</form>
			</div>
		</div>
		
		<div class="structure">
			<div class="structure_pic">
				<h3>Bio Farm</h3>
				<img src="images/Farm_Bio.png" alt="Bio Farm"/>
			</div>
			<div class="progress_bar" id="Farm_Bio">
				<div class="percent"></div>
				<div class="pbar"></div>
				<div class="elapsed"></div>
				
				<script type='text/javascript'>progress_bar(250, Farm_Bio);</script>
			</div>
			<div class="upgrade_button">
				<form action="upgrade.php" method="POST">
					<input type="hidden" name="building" value="Farm_Bio" />
					<input type="submit" value="Upgrade">
				</form>
			</div>
		</div>
		
		<div class="structure">
			<div class="structure_pic">
				<h3>Nuclear Powerplant</h3>
				<img src="images/Powerplant_Uranium.png" alt="Uranium Powerplant"/>
			</div>
			<div class="progress_bar" id="Powerplant">
				<div class="percent"></div>
				<div class="pbar"></div>
				<div class="elapsed"></div>
				
				<script type='text/javascript'>progress_bar(50, Powerplant);</script>
			</div>
			<div class="upgrade_button">
				<form action="upgrade.php" method="POST">
					<input type="hidden" name="building" value="Powerplant_Uranium" />
					<input type="submit" value="Upgrade">
				</form>
			</div>
		</div>
	</div>
</body>
</html>

			<!--  -->