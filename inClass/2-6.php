<?php
if(isset($_POST['zipcode'])){
    $zipcode=$_POST['zipcode'];
} else{
    $zipcode = '';
}


?>


<form method ='post' action ='2-6.php'>
    Enter a zip code
    <input type='text' name='zipcode' value ='<?=$zipcode?>'/>
    <input type='submit' value ='getWeather'/>

    
    
</form>

<table border='1'>
    <tr>
        <th>City</th>
        <th>Temp</th>
        <th>Condition</th>
    </tr>
   
</table>



<?php
if ($zipcode=''){
    exit();
}



$apikey = "df019887480aa0b2049d5febd50a782f";

$api_url = "http://api.openweathermap.org/data/2.5/weather?zip=".intval($zipcode).",us&APPID=".$apikey;

        
$result = file_get_contents($api_url);


$decoded = json_decode($result,true);


$name = $decoded['name'];
$temp1 = $decoded['main']['temp'];

$temp_f = KtoF($temp1);

echo "Right now its $temp_f in $name";

$code = $decoded['cod'];

if ($code != 200){
    echo "sorry the weathe ris not avaiblael";
    exit();
}

function KtoF($temp){
    $f = round((($temp-273)*9)/5.0);
    $z = $f + 32;
    return $z;
    
}

foreach($decoded['list'] as $city){
    $name =$city['name'];
    $temp =  KtoF($city['main']['temp'])
            $condition = $city['weather'][0]['main'];
    
    echo"<tr>"
    echo "<td>$name</td>";
    echo "<td>$temp</td>";
    echo "<td>$condition</td>";

    
    echo "</tr>";
         
    
}


?>


