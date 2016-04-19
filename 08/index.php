<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//init user input
$numberOfCases = 0;
$numberOfPacks = 0;
$baseNumber = 0;
$numberOfUncommon = 0;
$numberOfRare = 0;
$numberOfLegendary = 0;


//if user presses submit get user input
if (isset($_REQUEST['numberOfPacks'])) {

    $numberOfCases = intval(@$_REQUEST['numberOfCases']);
    $numberOfPacks = intval(@$_REQUEST['numberOfPacks']);
    $baseNumber = intval(@$_REQUEST['baseNumber']);
    $numberOfUncommon = intval(@$_REQUEST['numberOfUncommon']);
    $numberOfRare = intval(@$_REQUEST['numberOfRare']);
    $numberOfLegendary = intval(@$_REQUEST['numberOfLegendary']);
}
?>

<!--form for user input -->
<form method="request" action='index.php'>
    <table border="4">
        <tr>
            <th colspan='2'>Packaging Calculator</th>
        </tr>
        <tr> <td> Number of Cases: </td> <td><input type="text" name="numberOfCases" value='<?= ($numberOfCases) ? $numberOfCases : '' ?>'> </td> </tr>
        <tr> <td> Number of Packs in each Case: </td> <td><input type="text" name="numberOfPacks" value='<?= ($numberOfPacks) ? $numberOfPacks : '' ?>'> </td> </tr>
        <tr> <td>  Base Number of Card in each Pack: </td> <td><input type="text" name="baseNumber" value='<?= ($baseNumber) ? $baseNumber : '' ?>' </td> </tr>
        <tr> <td> Frequency of Uncommon cards: </td> <td><input type="text" name="numberOfUncommon" value='<?= ($numberOfUncommon) ? $numberOfUncommon : '' ?>' </td> </tr>
        <tr> <td>  Frequency of Rare Cards: </td> <td><input type="text" name="numberOfRare" value='<?= ($numberOfRare) ? $numberOfRare : '' ?>' </td> </tr>
        <tr> <td>  Frequency of Legendary Cards: </td> <td><input type="text" name="numberOfLegendary" value='<?= ($numberOfLegendary) ? $numberOfLegendary : '' ?>' </td> </tr>

        <tr> <td>  <input type="submit" value="Calculate"> </td>  <td> &nbsp;</td></tr>

    </table>




    <?php

    
    //init counters
    $totalPacks = $numberOfCases * $numberOfPacks;
    $counter = 0;
    $counterUnc = 0;
    $counterRar = 0;
    $counterLeg = 0;
    $counterCom = 0;

    /**
     * array of packs, each pack will be of type Pack with a cards array of type string
     */
    $packArr = array();

    class Pack {

        public $cards = array();
        
        
        /**
         * loop through cards and calculate average value of pack
         * @return double
         */
        public function getAverageValueOfPack(){
            
            $averagePackValue = 0;
            
           for ($i = 0; $i < count($this->cards); $i++){
               
               switch ($this->cards[$i]){
                   case "COM": $averagePackValue += 1; break;
                   case "UNC":  $averagePackValue += 3; break;
                   case "RAR": $averagePackValue += 7; break;
                   case "LEG": $averagePackValue += 12; break;
                    
               }
           }
           
           
           return $averagePackValue;      
        }
   
    }
    
    //for loop for array of packs

    
    if ($numberOfCases != 0 && $numberOfPacks != 0 && $baseNumber != 0){ //only calculate if user has inputted minimum data
    for ($i = 0; $i < $totalPacks; $i++) {

        $pack = new Pack();
        

        //for loop for each pack's cards.  If frequencies call for a certain card type then upon counter reaching that value, push this card type in cards array.  If no user input for
        //specific card type then dont add any of these cards
        for ($j = 0; $j < $baseNumber; $j++) {

            $counter++;

            if ($numberOfLegendary != 0 && $counter % $numberOfLegendary == 0) {
               
                    array_push($pack->cards, "LEG");
              
                $counterLeg++;
            } else if (($numberOfRare != 0 && $numberOfUncommon != 0) && ($counter % $numberOfRare == 0 && $counter % $numberOfUncommon == 0)) {
               
                $counterLeg++;
                   
                array_push($pack->cards, "LEG");
            } else if ($numberOfRare != 0 && $counter % $numberOfRare == 0) {
                
                $counterRar++;
                   
                array_push($pack->cards, "RAR");
            } else if ($numberOfUncommon != 0 && $counter % $numberOfUncommon == 0) {


                
                $counterUnc++;
                
                array_push($pack->cards, "UNC");
            } else {
                
                $counterCom++;
                  array_push($pack->cards, "COM");
            }
        }

        //push pack into array of packs
array_push($packArr,$pack);

    }
    
    //if user input then calculate data table
    if (isset($_REQUEST['numberOfPacks'])) {

        $totalValue = $counterCom * 1 + $counterUnc * 3 + $counterRar * 7 + $counterLeg * 12;
        $avgValue = $totalValue / $numberOfPacks;

        echo "<table border='1'>
    <tr> <th colspan='2'>Results</th></tr>
    <tr> <td> Number of Common Cards: </td> <td>$counterCom</td>
    <tr> <td> Number of Uncommon Cards: </td> <td>$counterUnc</td>
   <tr> <td> Number of Rare Cards: </td> <td>$counterRar</td>
       <tr> <td> Number of Legendary Cards: </td> <td>$counterLeg</td>
         <tr> <td> Average Pack Value: </td> <td>$avgValue</td>  
        ";

        echo "</table> </form>";
    }

    /**
     * determine if all cards in each park are common and determine if the average value of pack is less than overall average value. add common card to cards array if either are true
     */
      for ($i = 0; $i < count($packArr); $i++){
          $allCommon = true;
//for loop for packs array
        for ($j = 0; $j < count($packArr[$i]->cards); $j++){
           //for loop for cards array in each pack
                   
        if ($packArr[$i]->cards[$j] != "COM"){
            $allCommon = false;
        }
        
        }
        //end of inner for loop for elements in cards array
        if ($packArr[$i]->getAverageValueOfPack() < $avgValue){
            array_push($packArr[$i]->cards, "COM");
        }
        
   if ($allCommon == true){
            array_push($packArr[$i]->cards, "COM");
        }
        
    }

/**
 * echo out packs
 */
    for ($i = 0; $i < count($packArr); $i++){
        
        for ($j = 0; $j < count($packArr[$i]->cards); $j++){
            
             echo $packArr[$i]->cards[$j]." ";
             
        }
        //end of cards for loop
        
       // echo "<br>The average value of this pack before addition of extra common cards is ".number_format($packArr[$i]->getAverageValueOfPack(),2).".";
       echo "<br>";
        
    }
    }
    
    else {
        
        if (isset($_REQUEST['numberOfPacks'])){
        echo "Invalid Input. Try again";
        }
    }
    ?>

</form>
