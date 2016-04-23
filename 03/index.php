<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['food'])){
    $food=$_POST['food'];

} else{
    $food = '';
}

$api_key = "jmenke";

$apiURL = "http://96.126.107.46/food/?apikey=".$api_key."&term=".$food;


$resultFood = file_get_contents($apiURL);

$decodedFood = json_decode($resultFood,true);

//echo "<pre>";
//print_r($decodedFood);
//echo "</pre>";
$numResults = $decodedFood['total'];


?>

<form method ='post' action ='index.php'>
    Enter a food
    <input type='text' name='food' value ='<?=$food?>'/>
    <input type='submit' value ='Get Food Data'/>

    
    
</form>

<?php
if ($numResults == 0){
    echo "No search results found";
    exit();
    
}
else{
       echo "There were ".$numResults." results found.";
}

?>




<table border='1'>
    <tr>
        <th>Product Name</th>
        <th>Category</th>
        <th>Serving Size</th>
        <th>Calories</th>
        <th>Fat</th>
        <th>Saturated Fat</th>
        <th>Sodium</th>
    </tr>
    
    <?php
    

    
    
    foreach($decodedFood['results'] as $foods){
        $productName = $foods['product_name'];
        $category = $foods['category'];
        $servingSize = $foods['serving_size'];
        $calories = $foods['calories'];
        $fat = $foods['fat'];
        $satFat = $foods['saturated_fat'];
        $sodium = $foods['sodium'];
        
    echo"<tr>";
    echo "<td>".(($productName) ? $productName : '&nbsp')."</td>";
    echo "<td>".(($category) ? $category : '&nbsp')."</td>";
    echo "<td>".(($servingSize) ? $servingSize : '&nbsp')."</td>";
    echo "<td>".(($calories) ? $calories : '&nbsp')."</td>";
    echo "<td>".(($fat) ? $fat : '&nbsp')."</td>";
    echo "<td>".(($satFat) ? $satFat : '&nbsp')."</td>";
    echo "<td>".(($sodium) ? $sodium : '&nbsp')."</td>";

    echo "</tr>";
         
  
    
}
    echo "</table>";

 

    
    
    ?>
    

