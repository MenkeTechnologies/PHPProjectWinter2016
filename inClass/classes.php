<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class House {
   
    public $value;
    public $address;
    public $numberRooms = 3;
    private $_skeletons=1;

    public function __construct($address=null, $value=null) {
        $this->address = $address;
        $this->value = $value;
        $this->_skeletons++;
       
    }
    
    
    
    public function getListing (){
    $str = "My house is located at $this->address and the value is $$this->value";
    $str.=" is valued at something.<br/>";
        return $str;
    }
    
 
    
}

$obj = new House();
$obj->value = 100000;

$obj->address = '123 Elm Street';

echo $obj->getListing();


$house2 = new House("170 Elm Street",50000);
        
echo $house2->getListing();



?>

