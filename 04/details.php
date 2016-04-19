<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'connect.php';
$id = $_GET['id'];


$sql1 = "select event,site,round,player1,player2,opening,result,player1Elo,player2Elo,eco,DATE_FORMAT(matchDate, '%m/%d/%Y'),opening,moves
 from matches where id=" . intval($id);
$result = $pdo->query($sql1);
?>


<a href="index.php">Back to Main View</a>
<h1>Detail View</h1>

<table border = "2" cellpadding = "5" cellspacing="5">
    <tr>
        <th>Event Name</th>
        <th>Event Site</th>

        <th>Date</th>
        <th>Round<br> Number</br></th>

        <th>Player 1 and Elo</th>
        <th>Player 2 and Elo</th>
        <th>Result</th>
        <th>Opening and ECO</th>



    </tr>

<?php
$row = $result->fetch(PDO::FETCH_ASSOC);
$matchDate = $row['DATE_FORMAT(matchDate, \'%m/%d/%Y\')'];
$eventName = $row['event'];
$eventSite = $row['site'];
$round = $row['round'];
$player1 = $row['player1'];
$player1Elo = $row['player1Elo'];
$player2Elo = $row['player2Elo'];
$openingRaw = $row['opening'];
$openingArr = explode(";", $openingRaw);
$opening = $openingArr[0];
$player2 = $row['player2'];
$resultMatchRaw = $row['result'];

if ($resultMatchRaw == "D") {
    $resultMatch = "Draw";
} else if ($resultMatchRaw == '1') {
    $resultMatch = $player1;
} else {
    $resultMatch = $player2;
}
$ecoCode = $row['eco'];
$moves = $row['moves'];


echo "<tr>";
echo "<td>" . (($eventName) ? $eventName : '&nbsp') . "</td>";
echo "<td>" . (($eventSite) ? $eventSite : '&nbsp') . "</td>";

echo "<td>" . (($matchDate) ? $matchDate : '&nbsp') . "</td>";
echo "<td>" . (($round) ? $round : '&nbsp') . "</td>";

echo "<td>" . (($player1) ? $player1 : '&nbsp') . " <b>" . (($player1Elo) ? $player1Elo : '&nbsp') . "</b></td>";
echo "<td>" . (($player2) ? $player2 : '&nbsp') . " <b>" . (($player2Elo) ? $player2Elo : '&nbsp') . "</b></td>";
echo "<td>" . (($resultMatch) ? $resultMatch : '&nbsp') . "</td>";
echo "<td>" . (($opening) ? $opening : 'N/A') . " <b>" . (($ecoCode) ? $ecoCode : '&nbsp') . "</b></td>";
echo"</tr>";





echo "</table>";

echo "<h2>Moves: </h2>";

echo (($moves) ? $moves : 'N/A');

