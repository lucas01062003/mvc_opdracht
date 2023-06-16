<?php

namespace App\Entity;

class robot_battle
{
    public $id;
    public $robot_id;
    public $battle_id;
    public $victory;

    public function __construct($id = null, $robot_id = null, $battle_id = null, $victory = null)
    {
        $this->id = $id;
        $this->robot_id = null;
        $this->victory = null;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getRobotId(){
        return $this->robot_id;
    }

    public function setRobotId($robotId){
        $this->robot_id = $robotId;
    }

    public function getVictory(){
        return $this->victory;
    }

    public function setVictory($victory){
        $this->victory = $victory;
    }
}