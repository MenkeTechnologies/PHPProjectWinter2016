<h1>Chess Match Database</h1>


<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'connect.php'; //connect to database



if (isset($_POST['nameSearch'])) { //get Name Search Text Field Data when form submitted
    $nameSearch = $_POST['nameSearch'];
    $playerSort = "player1 like '%$nameSearch%' or player2 like '%$nameSearch%'";
//set sqrl query with Name Search text field Data for filtering
} else {  //keep text field blank and do not filter with no data entered in text field
    $nameSearch = '';
    $playerSort = '1';
}
//PHP requests setting timezone for date formatting
date_default_timezone_set('America/Detroit');

if (isset($_POST['firstDate']) && isset($_POST['secondDate'])) {
////get date filtering data from text fields when form submitted
    $firstDate = $_POST['firstDate'];
    $secondDate = $_POST['secondDate'];

    $dateSort = '1';  //if no date data entered in fields do not filter by data

    if ($firstDate != '' && $secondDate != '') {
        //if text fields are not blank convert date format to sql ready format
        $firstDatePreFormatting = DateTime::createFromFormat('m/d/Y', $firstDate);
        $firstDateFormatted = $firstDatePreFormatting->format('Y-m-d');

        $secondDatePreFormatting = DateTime::createFromFormat('m/d/Y', $secondDate);
        $secondDateFormatted = $secondDatePreFormatting->format('Y-m-d');
        //set sqrl query condition for filtering with properly formatted date data
        $dateSort = "matchDate between '$firstDateFormatted' and '$secondDateFormatted'";
    }
} else { //keep text field blank and do not filter with no data entered in text field inititially
    $firstDate = '';
    $secondDate = '';
    $dateSort = "1";
}

////get result of match filtering data from text fields when form submitted
if (isset($_POST['dropDown'])) {
    $dropChoice = $_POST['dropDown'];


    //set sqrl query condition for filtering with properly formatted result

    $resultSort = "result='$dropChoice'";

    //do not filter if dropdown choice is any
    if ($dropChoice == "any") {
        $resultSort = "1";
    }
} else {    //do not filter if no dropdown choice
    $dropChoice = '';
    $resultSort = "1";
}

//assocative array for remembering selection in dropdown box
$dropArray = array('any' => '', '1' => '', '2' => '', 'D' => '');

//loop thru array and change value in array to 'selected' if this choice was chosen before form submitted
//if choice was not selected then add blank value AKA not selected
foreach ($dropArray as $x => &$s) {
    if ($dropChoice == $x) {

        $s = "selected";
    } else {
        $s = "";
    }
}
//get values from associative array of dropdown choices for adding 'selected' to dropdown choices
$values = array_values($dropArray);


//main sql query with sorting conditions.
//if no data in text fields and dropdown then change conditions to '1' so all results displayed
//date data has been directly formatted from sql for populating table
$sql = "select id,player1,player2,result,eco,DATE_FORMAT(matchDate, '%m/%d/%Y')
 from matches where (1) and ($playerSort) and ($resultSort) and ($dateSort) order by matchDate desc limit 250";
$result = $pdo->query($sql);
?>

<form method="post" action="index.php">
    First Date <input type="text" name="firstDate" value ="<?= $firstDate ?>" size="8">
    Second Date <input type="text" name ="secondDate" value ="<?= $secondDate ?>" size="8">
    Name Search <input type="text" name = "nameSearch" value ="<?= $nameSearch ?>"size="15">


    <select name="dropDown">

       
<?php

//dropdown choices, values sent to resultSort
echo "<option value ='any'" . $values[0] . ">Any Outcome</option>";
echo "<option value ='1'" . $values[1] . ">Player 1</option>";
echo "<option value ='2'" . $values[2] . ">Player 2</option>";
echo "<option value ='D'" . $values[3] . ">Draw</option>";
?>

    </select>

    <input type="submit" value="FilterData">

</form>


<table border = "2" cellpadding = "5" cellspacing="5">
    <tr>
        <th>Date</th>
        <th>Player 1</th>
        <th>Player 2</th>
        <th>Result</th>
        <th>ECO</th>
        <th>More info </th>
    </tr>

<?php
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $matchDate = $row['DATE_FORMAT(matchDate, \'%m/%d/%Y\')'];
    $player1 = $row['player1'];
    $player2 = $row['player2'];
    $resultMatchRaw = $row['result'];

    //formatting of Outcome table data
    if ($resultMatchRaw == "D") {
        $resultMatch = "Draw";
    } else if ($resultMatchRaw == '1') {
        $resultMatch = $player1;
    } else {
        $resultMatch = $player2;
    }

    $ecoCode = $row['eco'];
    $id = $row['id'];
//table data, if no data available keep table cell empty
    echo"<tr>";
    echo "<td>" . (($matchDate) ? $matchDate : '&nbsp') . "</td>";
    echo "<td>" . (($player1) ? $player1 : '&nbsp') . "</td>";
    echo "<td>" . (($player2) ? $player2 : '&nbsp') . "</td>";
    echo "<td>" . (($resultMatch) ? $resultMatch : '&nbsp') . "</td>";
    echo "<td>" . (($ecoCode) ? $ecoCode : '&nbsp') . "</td>";

    echo "<td><a href=\"details.php?id=" . $id . "\">Details</a> </td>";



    echo "</tr>";
}
?>
</table>



