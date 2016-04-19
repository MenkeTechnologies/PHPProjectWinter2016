<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$ratings = array('kid'=> 'For Kids','adult' => 'For Adults','all_ages' => 'For All Ages');



include_once("connect.php");

$sql ="Select * from games order by title";

$result = $pdo->query($sql);

echo "the results found is ".$result->rowCount();
?>

<hr/>

<table border = "1">
    <tr>
        <th>
            Title
        </th>
        <th>Players</th>
        <th>Type</th>
        <th>Rating</th>
        
    </tr>
    
    <?php
    
    while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        
        if ($row['maxPlayers']>0){
            $players=$row['minPlayers']."-".$row['maxPlayers'];
        }
        else {
            $row['minPlayers'].'+';
        }
        
        echo "<tr>";
        echo "<td>".$row['title']."</td>";
                echo "<td>".$players."</td>";
        echo "<td>".ucfirst($row['type'])."</td>";
        echo "<td>".$ratings[$row['ageRating']]."</td>";
        
        echo "</tr>";
    }
    
    
    
    
    
    ?>
    
    <select name ='type'>
        <option value="board">Board</option>
                <option value="video">Video</option>
        <option value="card">Card</option>
        <option value="table">Table</option>
        <option value="description">Description</option>

        
    </select>
    
    <select name="ageRating">
        <option value="kid">Kid</option>
                <option value="adult">Adult</option>
        <option value="all_ages">All Ages</option>

    </select>
    
</table>