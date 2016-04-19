<?php

class Hello {
   
    public $today;
    public $kittyname;



    public function world(){
      
      View::setTemplate('hello_template');
      
      $this->today = date('n/j/Y');
      
   }
   
    public function kitty($name=NULL){
        $this->kittyname = $name;
       View::setTemplate('mynewtemplate');
   }
   
   
}