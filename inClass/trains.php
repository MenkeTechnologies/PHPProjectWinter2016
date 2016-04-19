<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//query from db



///make connection to db
include 'connect.php';
echo "connected to database<br/>";

//make query

$sql ="select * from trains where name = ? OR engine = ?";
$result = $pdo->prepare($sql);
$result -> execute(array(1,2));




//print results

echo $result->rowCount();
echo "<br/>";

while($row = $result->fetch(PDO::FETCH_ASSOC)){
    echo $row['id']." is ".$row['name']."<br/>";
}











?>
