<?php

/*
 * created by Jacob Menke
 * 
 */

class boardgame {

    private $gameID;
    private $title;
    private $subtitle;
    private $minPlayers;
    private $releaseDate;
    private $type;
    private $publisher;
    private $description;
    private $ageRating;

    public function __construct($id = NULL) {
        if ($id > 0) {
            $pdo = DB::get();
            $sql = "select * from games where gameID=?";
            $query = $pdo->prepare($sql);
            $query->execute(array($id));
            if ($query->rowCount() == 1) {
                $assoc = $query->fetch(PDO::FETCH_ASSOC);

                foreach ($assoc as $key => $value) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function __get($name) {
        switch ($key) {
            case 'gameID': return $this->gameID;
            case 'title': return $this->title;
            case 'subtitle': return $this->subtitle;
            case 'minPlayers': return $this->minPlayers;
            case 'releaseDate': 
                $ts = strtotime($this->releaseDate);
                if (!$ts){
                    return "unknown";
                }
                $date = date('n/j/Y',$ts);
                return $date;
            case 'type': return $this->type;
            case 'publisher': return $this->publisher;
            case 'description': return $this->description;
            case 'ageRating': return $this->ageRating;
        }
        ;
    }

    public function __set($name, $value) {
        
        if ($key =="releaseDate"){
            $ts = strtotime($value);
            if (!$ts) $value = NULL;
            else $value=  date ('Y-m-d',$ts);
        }
        
        
        $this->{key} = $value;
    }

    public function save() {
     $pdo = DB::get();
        
        if($this->gameID > 0){
         //update database
            
            $sql = "Update games set title=?, subtitle=?,minPlayers=?,maxPlayers=?,releaseDate=?,type=?,publisher=?"
                    . ",description=?,ageRating=? where gameID=?";
            $params=array($this->title, $this->subtitle, $this->minPlayers, $this->maxPlayers, $this->releaseDate, $this->type, $this->publisher,$this->description,$this->ageRating, $this->gameID);
               $query = $pdo->prepare($sql);
            $query->execute($params);
            $this->gameID = $pdo->lastInsertId();
         
     }  else {
         
     } 
    }

}
