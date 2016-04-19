<link rel="stylesheet" type="text/css" href="brackets.css"/>

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ('game.php');
include ('round.php');
include ('team.php');

//make 2 teams an play a match
//$teamA = new Team("Maryland",5);
//$teamB = new Team("South Dakota state", 11);
//
//$game = new Game($teamA, $teamB);
//
//echo $game->play();

$round = new Round();

$team_string = file_get_contents("brackets.txt");

$arr = explode("\n", $team_string);

foreach ($arr as $line) {
    $parts = explode(",", $line);
    $seed = $parts[0];
    $name = $parts[1];
    $team = new Team($name, $seed);

    $round->addTeam($team);
}

echo "<div class='commentary'>" . $round->play() . "</div>";
echo $round->draw();
