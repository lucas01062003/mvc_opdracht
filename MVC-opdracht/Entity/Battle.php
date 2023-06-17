<?php
namespace App\Entity;

class Battle
{
    public $id;
    public $date;
    public $type;
    public $robots; //array of robot classes
    public $winner; //robot class

    const TYPE_SHORT = '5 min max';
    const TYPE_medium = '10 min max';
    const TYPE_long = '20 min max';

    public function __construct($id = null, $date = null, $type = null, $robots = [], $winner = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->type = $type;
        $this->robots = $robots;
        $this->winner = $winner;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function getType(){
        return $this->type;
    }

    public function setDate($date){
        $this->date = $date;
    }
    public function getDate(){
        return $this->date;
    }

    public function setType($type)
    {
        if (!in_array($type, [self::TYPE_SHORT, self::TYPE_medium, self::TYPE_long])) {
            throw new \InvalidArgumentException("Invalid battle type.");
        }

        $this->type = $type;
    }

    public function getRobots(){
        return $this->robots;
    }
    public function setRobots($robots){
        $this->robots = $robots;
    }

    public function getWinner(){
        return $this->winner;
    }
    public function setWinner($winner){
        $this->winner = $winner;
    }
}