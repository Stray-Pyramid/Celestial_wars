var coal = 50;
var coal_inc = 5 / 4;
var iron = 20;
var iron_inc = 10 / 4;
var food = 30;
var food_inc = 2 / 4;

$('#res_coal').html(coal);
$('#res_iron').html(iron);
$('#res_food').html(food);

setInterval(function() {
     var value = parseInt($('#res_coal').html());
     coal = coal + coal_inc;
     $('#res_coal').html(coal);
}, 250);

setInterval(function() {
     var value = parseInt($('#res_iron').html());
     iron = iron + iron_inc;
     $('#res_iron').html(iron);
}, 250);

setInterval(function() {
     var value = parseInt($('#res_food').html());
     food = food + food_inc;
     $('#res_food').html(food);
}, 250);

	var coal = <?php echo ($player['res_coal'] + ((strtotime('now') - strtotime($player['last_updated'])) * $struc[0]['producing'])) / 4;?>
	var coal_inc = <?php echo ($struc[0]['producing'] ?>
	var iron = <?php echo ($player['res_iron'] + ((strtotime('now') - strtotime($player['last_updated'])) * $struc[1]['producing'])) / 4;?>
	var iron_inc = <?php echo ($struc[1]['producing'] ?>
	var food = <?php echo ($player['res_food'] + ((strtotime('now') - strtotime($player['last_updated'])) * $struc[2]['producing'])) / 4;?>
	var food_inc = <?php echo ($struc[2]['producing'] ?>