<?php
namespace App\Entity;

class Robot
{
    public $id;
    public $name;
    public $owner;
    public $weapon;
    public $armour ;
    public $propulsion;
    public function __construct($id = null, $name = null, $owner = null, $weapon = null, $armour = null, $propulsion = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;
        $this->weapon = $weapon;
        $this->armour = $armour;
        $this->propulsion = $propulsion;
    }

    public function getId(){
        return $this->id;
    }

    public function setId(){

    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getOwner(){
        return $this->owner;
    }

    public function setOwner($owner){
        $this->owner = $owner;
    }

    public function getWeapon(){
        return $this->weapon;
    }

    public function setWeapon($weapon){
        $this->weapon = $weapon;
    }

    public function getarmour(){
        return $this->armour;
    }

    public function setarmour($armour){
        $this->armour = $armour;
    }

    public function getPropulsion(){
        return $this->propulsion;
    }

    public function setPropulsion($propulsion){
        $this->propulsion = $propulsion;
    }








}