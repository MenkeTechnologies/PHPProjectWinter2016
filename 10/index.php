<?php

/**
 *		CPS 276 Winter 2016-- Assignment 01
 * 	Aquarium Cost Estimator
 */

// first, some notes...

// <-- Comments in PHP can be added with two forward slashes -- the comment continues until the next line
#  <-- Or with an octothorp (hash sign)
/* <-- Or for mutiple lines,
		 sandwiched between these characters -->  */

// Variables are identified with a dollar sign:
$a = 5;

// -------------------------------------------------------

// Your assignment is to calculate the following values...

$materials_cost = 0;		// cost of materials: glass, fish, water, etc
$labor_cost = 0;			// cost of putting it together
$total_cost = 0;			// the grand total
$time_required = 0;		// the total number of hours required
$total_fish = 0;			// total fish in a fully-stocked tank
$regular_fish = 0;
$fancy_fish = 0;

// here is the input... (no changes needed here)

$width = intval(@$_REQUEST['width']);
$height = intval(@$_REQUEST['height']);
$depth = intval(@$_REQUEST['depth']);


// you can set the following variable to a string, to report any errors at the end.
$error='';
// Example: $error='Width cannot be a negative number.';

// START WORKING HERE...

// Part 1: Materials Cost

$surfaceArea = 2.0* ($width*$height) + 2.0* ($width*$depth) + 2.0* ($depth*$height);
$totalVolume = $height*$width*$depth;

$rawMaterialsCostGlass = $surfaceArea * 0.03;
$rawMaterialsCostWater = $totalVolume * 0.001;
$fishCanFit = floor($totalVolume / 275);
 $fancyFishNumber = intval(0.07 * $fishCanFit);
 if (($fancyFishNumber + 2) % 2 != 0) {
     $fancy_fish = $fancyFishNumber - 1;
 }
 else {
     $fancy_fish = $fancyFishNumber;
 }
  
            $regular_fish = $fishCanFit - $fancy_fish;

$total_fish = $fancy_fish + $regular_fish;
$costFish = $regular_fish * 0.61 + $fancy_fish * 1.98;
$costAccessories = 7.95;

$unformattedMaterialsCost = $rawMaterialsCostGlass + $rawMaterialsCostWater + $costFish + $costAccessories;


/*		
		A. Start by finding the total surface area of the aquarium. Assume that the aquarium is glass on all six sides. Store this as $glass_surface. Hint: (W*H)*2 + (W*D)*2 + (H*D)*2
		B. Also find the total volume of the aquarium, and store as $total_volume. Assume the tank will be filled completely to the top.
		C. Raw materials cost: glass costs $0.03 per cm/sq.
		D. Raw materials cost: purified water costs $0.001 per cm3 (cubic centimeter).
		E. Each fish requires 275 cm3 of space. Find the maximum number of fish that can fit in the tank. ** Hint: use the floor() function to round down.
		F. NOT more than 7% of the fish will be fancy fish ($1.98 each). There must be an even number of fancy fish. Add as many fancy fish as possible. The rest will be regular fish ($0.61 each).
		G. Add a small castle and lighting: $7.95
		H. The sum of C,D,F,and G and the total materials cost. 
*/




// Part 2: Time Required


/*
		The time required will be used to calculate the labor costs
		A. There are two times to keep track of: time to construct the tank ($tank_time) and time to stock the fish ($stock_time), both measured in seconds.
		B. For the tank time, use the FOR loop below.
		   Start with x= the total volume of the tank (cm3)
		   The first side takes x seconds to construct
			Each successive side takes 10% less time than the previous
		C. Stock time is 3 seconds per fish.
		D. the total time is the sum of the tank time and the stock time, measured in minutes.
*/

$tank_time=0;
$stock_time=0;



// tank time
    $x = $totalVolume;
    
   

    
for($i = 0; $i < 6; $i++){
	$tank_time += $x*(pow(0.9,$i)); 
}

$stock_time = 3 * $total_fish;
$timeRequiredMinutes = ($tank_time + $stock_time)/ 60;
$time_required = ceil($timeRequiredMinutes);

// Part 3: Labor Costs and Grand Total

/* 	A. The staff are aquarium professionals, paid $33.71 per hour or portion thereof. ** Hint: round up to the nearest hour with the ceil() function
		B. Add $12 handling fee.
		C. Calculate the grand total (materials and labor and fees)
		D. There's a sale going on! If the total is greater than $250, give a 30% discount. If between $100-$249, give a 10% discount.
		E. Use the number_format function to alter the math precision for currency.
			Example: $amount = number_format($amount, 2);   -->  would turn 24.022278 into 24.02
*/

$unformattedLaborCost = ceil($timeRequiredMinutes / 60.0) * 33.71;

$handlingFee = 12;
$presaleCost = $unformattedLaborCost + $unformattedMaterialsCost + $handlingFee;
$unformattedTotalCost = 0;

if ($presaleCost > 250){
    $unformattedTotalCost = $presaleCost * 0.7;    
}

else if ($presaleCost >= 100 && $presaleCost <= 249) {
    $unformattedTotalCost = $presaleCost * 0.9;
}
else {
    $unformattedTotalCost = $presaleCost;
}

$formattedPreSaleCost = '$'.number_format($presaleCost, 2);

$labor_cost = '$'.number_format($unformattedLaborCost, 2);
$materials_cost = '$'.number_format($unformattedMaterialsCost, 2);
$total_cost = '$'.number_format($unformattedTotalCost, 2);

/*		What follows is the HTML form used to present the application.
 		No changes are needed beyond this point, but it's a good idea to look this over.
 		You will be making your own forms in future assignments. */

echo $error;
if($width==0 || $height == 0 || $depth == 0 ){
    $width='';
    $height = '';
    $depth = '';
    

    $materials_cost = '';
    $labor_cost = '';
    $total_cost = '';
   
}   


?>
<form method='get' action='index.php'>
	<table border='1'>
		<tr>
			<th colspan='2'>Aquarium Cost Estimator</th>
		</tr>
		<tr>
			<td>Width</td>
			<td><input type='text' name='width' value='<?=$width?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>Height</td>
			<td><input type='text' name='height' value='<?=$height?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>Depth</td>
			<td><input type='text' name='depth' value='<?=$depth?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type='submit' value='Calculate'/></td>
		</tr>
		<tr>
			<th colspan='2'>Results</th>
		</tr>
		<tr>
			<td>Total Fish</td>
			<td><?php if($total_fish) echo $total_fish.' ('.$fancy_fish.' fancy)'; else echo '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Materials Cost</td>
			<td><?=($materials_cost) ? $materials_cost: '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Labor Cost</td>
			<td><?=($labor_cost) ? $labor_cost : '&nbsp;'?></td>
		</tr>
               
		<tr>
			<td>Total Cost</td>
			<td><?php if ($total_fish) echo $formattedPreSaleCost.' ('. $total_cost.' after discount)'; else echo '&nbsp'?></td>
		</tr>
		<tr>
			<td>Time Required</td>
			<td><?=($time_required)?$time_required.' minutes':'&nbsp;'?></td>
		</tr>
	</table>
</form>
