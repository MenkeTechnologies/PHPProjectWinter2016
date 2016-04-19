<?php
session_start();

if(isset($_REQUEST['mynumber'])){
$input = $_REQUEST['mynumber'];
}
else{
    
    $input = '';
}

?>

<form method ="post" action="luhn.php">
      Enter a number:
      <input type ="text" name ="mynumber" value="<?=$input?>"/>
      
      <input type="submit" value ="Check"/>

      
      
      
</form>

<?php


/**
 * Calculate luhnness of number
 * @param type $number
 * @return boolean
 */

$result = isLuhn($input);

if ($result){
    
    echo "the number $input is a luhn number";
}
else{
    echo "the num $input is not a luhnio";
    
}
        
function isLuhn($number){
    
    $digits = str_split($number);
    $digits = array_reverse($digits);
    
    for ($i=1; $i< count($digits); $i+=2){
        
       $value = $digits[$i];
       $value *= 2;
       
       if ($value > 9){
           
           $value = $value -9;
           
       }
       
       $digits[$i] = $value;
       
       
       
    }
    
    $sum = array_sum($digits);
    
   
    
 
 
$result = $sum % 10;
if ($result == 0){
    return true;
}
else {
    return false;
}
 
    
}

if (isset($_SESSION['n'])){
    $_SESSION['n']++;
    
}
else{
    $_SESSION['n']=1;
}

echo "n=".$_SESSION['n'];



?>