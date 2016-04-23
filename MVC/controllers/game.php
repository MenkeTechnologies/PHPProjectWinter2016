<?php

class Game {
   
    public function listing(){
        //show list of all games
        
       
       //prepare an array
        
        //passs this to the view
        
        View::setTemplate('gameListing');
    }

    public function add(){
     //a form to add a game 
     
      
   }
   
     public function edit(){
      
     //form to edit a game(known to us as id)
         
         //load that record
      
   }
   
   public function details($id){
  //data about 1 game
       
       $g = new boardgame($id);
       
       $this->mygame = $g;
       View::setTemplate('gamedetails');  
       
       //load that record
   }
   
   public function delete ($id){
       
   
   }
   
  
   
   
}