<!DOCTYPE html>
<html lang="en">
<head>
	<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
	<link href="css/main.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
	<script type="text/javascript" src="js/script.js"></script>

	<title>Animated jQuery progressbar | Script tutorials</title>
	
	<?php
		require_once '../../database_connection.php';


		$time = 100; //Default upgrade time
				
		$player_query = mysql_query("SELECT * FROM player_status WHERE user_id=1");
		$player = mysql_fetch_array($player_query);
		
		$struc_query = mysql_query("SELECT level, producing, upkeep, is_upgrading, upgrade_start, upgrade_duration FROM structure_status WHERE user_id='1'");
		$i=0;

		while($struc_result = mysql_fetch_array($struc_query))
		{
			$struc[$i]['level']=$struc_result['level'];
			$struc[$i]['producing']=$struc_result['producing'];
			$struc[$i]['upkeep']=$struc_result['upkeep'];
			$struc[$i]['is_upgrading']=$struc_result['is_upgrading'];
			$struc[$i]['upgrade_start']=$struc_result['upgrade_start'];
			$struc[$i]['upgrade_duration']=$struc_result['upgrade_duration'];
			
			$i++;
		}
	?>
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
				<li><img src="images/coal_icon.png"><?php echo $player['res_coal'];?></li>
				<li><img src="images/iron_icon.png"><?php echo $player['res_iron']?></li>
				<li><img src="images/food_icon.png"><?php echo $player['res_food']?></li>
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
						$time_to_finish = 100;
						echo "<script type='text/javascript'>progress_bar({$time}, Mine_Coal);</script>";//Add '$time till finish' script
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
	<?php
		require_once 'item_updater.php';
	?>
</body>
</html>

			<!--  -->