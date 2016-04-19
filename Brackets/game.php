<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Game {

    private $teamA;
    private $teamB;
    private $winner = "";
    private $teamAScore = 0;
    private $teamBScore = 0;

    /**
     * Class to represent a basketball game
     * @param Team $teamA
     * @param Team $teamB
     */
    
    public function __construct(Team $teamA, Team $teamB) {
        $this->teamA = $teamA;
        $this->teamB = $teamB;
    }


    

    /**
     * Play the game
     * @return String
     */
    public function play() {
        $commentary = "STARTING A GAME<br> between ".$this->teamA->name." and ".$this->teamB->name.". ";
                
                do {
            $this->teamAScore = $this->teamA->makeScore();
            $this->teamBScore = $this->teamB->makeScore();
        } while ($this->teamAScore == $this->teamBScore);

             $commentary.="Final score is $this->teamAScore for ".$this->teamA->name." and $this->teamBScore for ".$this->teamB->name."";
        if ($this->teamAScore > $this->teamBScore) {
            $this->winner = 0;
                    $commentary.= "<br>Winner is ".$this->teamA->name."<br>";
        } else {
            $this->winner = 1;
            $commentary.= "<br>Winner is ".$this->teamB->name."<br>";
        }
        
   
        return $commentary;
        
    }
    
        public function getWinner () {
            if ($this->winner == 0){
                return $this->teamA;
            }
   
            elseif ($this->winner == 1) {
                return $this->teamB;
            }
    }
    
    public function draw($n, $i){
        $str="";
        $str.=$this->teamA->draw($n,$i,1,$this->teamAScore);
                $str.=$this->teamB->draw($n,$i,2,$this->teamBScore);
                
                return $str;

            
    }


}
