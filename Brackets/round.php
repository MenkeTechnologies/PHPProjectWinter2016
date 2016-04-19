<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Round {

    private $teams = array();
    private $games = array();
    private $nextRound;

    
    
    public function play() {
        $teamNum = count($this->teams);

        $message = "Starting a round with $teamNum teams...<br/>";

        //create games
        for ($i = 0; $i < $teamNum; $i+=2) {
            $teamA = $this->teams[$i];
            $teamB = $this->teams[$i + 1];
            $game = new Game($teamA, $teamB);
            $this->games[] = $game;
        }
        $gamesNum = count($this->games);

        $message.="playing $gamesNum games...<br/>";
        //play games

        foreach ($this->games as $game) {
            $str = $game->play();
            $message .= $str;
        }

        if ($gamesNum > 1) {
            $this->nextRound = new Round();
            
            foreach ($this->games as $game) {
                $winner = $game->getWinner();
                $this->nextRound->addTeam($winner);
            }

            $str = $this->nextRound->play();
            $message.= $str;
        }



        //another round?

        return $message;
    }
    
 public function addTeam(Team $team) {
        $this->teams[] = $team;
    }
    
    public function draw (){
        $str = '';
        $n = count($this->games);
        $i = 0;
        foreach ($this->games as $game) {
            $str .= $game->draw($n,$i);
            $i++;
            
        }
        
        if ($this->nextRound){
            $str.=$this->nextRound->draw();
            $i++;
        }
        
        return $str;
    }

   

}
