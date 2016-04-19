<?php //

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "design pattern!<br/>";
//
//class Counter {
//
//    protected static $instance;
//  private function __construct() {}
//    private function __clone() {}
//
//
//    public static function get() {
//        if (!isset(self::$instance)) {
//       self::$instance = new self();
//        }
//        
//        return self::$instance;
//    }
//    
//    private $count = 0;
//    public function increment (){
//        $this->count++; 
//    }
//    
//    public function getCount (){
//        return $this->count;
//    }
//
//}
//
//$c = Counter::get();
//
//$c->increment();
//
//echo $c->getCount();
//$c->increment();
//$c = null;
//
//$d = Counter::get();
//$d->increment();
//echo $d->getCount();
//
//$fred = new Client();
//$fred->name = "fred";
//$fred->save();
//$fred->email = "fred@fred.com"
//
//
////factory
//
//abstract class Person {
//      public $coolness;
//}
//
//class Doctor extends Person {
//    public $coolness = 5;
//}
//
//class Lawyer extends Person {
//    public $coolness = -5;
//}
//
//class SoftwareDeveloper extends Person {
//    public $coolness = 1000;
//}
//
//class PersonFactory {
//    public static function makePerson(){
//        $r = rand(1, 3);
//        if ($r == 1){
//            return new Doctor();
//            
//        }
//        
//        else if ($r == 2){
//            return new Lawyer();
//        }
//        else {
//            return new SoftwareDeveloper();
//        }
//        
//    }
//}
//
//
//$per = PersonFactory::makePerson();
//print_r($per);


//visitors
class Visitor{
    public $lowest = 999999;
    public $highest = 0;
    public $totalValue = 0;
    public $houseCount = 0;
}

class House {
    private $price;
    public function __construct() {
        $this->price = rand(50000, 750000);
    }
    
    public function getPrice (){
        return $this->price;
    }
    
    public function process (Visitor $v){
        if ($this->price < $v->lowest){
            $v->lowest = $this->price;
        }
        
        if ($this->price > $v->lowest){
            $v->highest = $this->price;
        }
        
        $v->totalValue += $this->price;
        
       $v->houseCount++;
        
    }
    
    
           
}

$arr = array();

for ($i = 0; $i < 10; $i++){
    $arr[] = new House ();
}

$visitor = new Visitor();

foreach ($arr as $listing){
    echo $listing->getPrice()."<br>";
    $listing->process($visitor);
}

echo "lowest price is ".number_format($visitor->lowest,2)." <br/>";
echo "highest price is ".number_format($visitor->highest,2)." <br/>";
$a = $visitor->totalValue/$visitor->houseCount;

echo "average price is ".number_format($a,2);

echo "<hr/>";

for ($i = 1; $i <=1000; $i++){
    $f = true;
    if ($i % 5 == 0){
        echo "fizz ";
        $f = false;
    }
     if ($i % 7 ==0){
        echo "buzz ";
        $f = false;
    }
    
    if ($f){
        echo "$i ";
    }
 
}

echo '<hr/>';
echo "fizzbuzz (visitor method)<br/>";

class Node {
    private $num;
    
    public function __construct($num) {
        $this->num = $num;
    }
    public function __toString() {
        return $this->num." ";
    }
    
    public function process(fizzer $f){
        $result = $f->increment();
        if ($result){
            $this->num = $result;
        }
    }
    
}

class fizzer {
    private $fizzCount = 0;
    private $buzzCount = 0;
    
    public function increment(){
        $this->fizzCount++;
        $this->buzzCount++;
        $out = '';
        if ($this->fizzCount == 5){
            $this->fizzCount = 0;
            $out.="fizz";
        }
        if ($this->buzzCount == 7){
            $this->buzzCount = 0;
            $out.="buzz";
        }
        return $out;
        
        
    }
}

$arr = array();

for ($i = 1; $i <= 1000; $i++){
    $arr[]= new Node($i);
    
}

$f = new fizzer();
foreach ($arr as $node){
    $node->process($f);
    echo $node;
}


?>

