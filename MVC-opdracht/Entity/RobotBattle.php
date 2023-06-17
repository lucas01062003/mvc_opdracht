<?php

namespace App\Entity;

class RobotBattle
{
    public $id;
    public $robot;
    public $battle;

    public function __construct($id = null, $robot = null, $battle = null, $victory = null)
    {
        $this->id = $id;
        $this->robot = $battle;
        $this->battle = null;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getRobot(){
        return $this->robot;
    }

    public function setRobot($robot){
        $this->robot = $robot;
    }

    public function getBattle(){
        return $this->battle;
    }

    public function setBattle($battle){
        $this->battle = $battle;
    }

}