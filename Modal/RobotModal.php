<?php
namespace App\Modal;

include  "./Repository/RobotRepository.php";
use App\Entity\Robot;
use App\Repository\RobotRepository;

class RobotModal
{
    private $robotRepository;
    private $db;
    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
    }

    public function getRobots(){
        return $this->robotRepository->findAll();
    }

    public function createRobot($id, $name, $owner, $weapon, $armour, $propulsion){
        $robot = new Robot($id, $name, $owner, $weapon, $armour, $propulsion);
        $this->db->saveEntity($robot,true);
    }

    public function deleteRobot($id){
        $this->db->delete('robot', $id, true);
    }
}