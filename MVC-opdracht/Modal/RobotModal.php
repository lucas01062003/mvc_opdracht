<?php
namespace App\Modal;

include  "./Repository/RobotRepository.php";
include  "./Repository/RobotBattleRepository.php";
use App\Entity\Robot;
use App\Repository\RobotBattleRepository;
use App\Repository\RobotRepository;

class RobotModal
{
    private $robotRepository;
    private $db;
    private $robotBattleRepository;
    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
        $this->robotBattleRepository = new RobotBattleRepository();
    }

    public function getRobots(){
        return $this->robotRepository->findAll();
    }

    public function saveRobot($id, $name, $owner, $weapon, $armour, $propulsion){
        $robot = new Robot($id, $name, $owner, $weapon, $armour, $propulsion);
        $this->db->saveEntity($robot,true);
    }

    public function deleteRobot($id){
        $this->db->openConnection();

        // delete all battles with robot
        $rawBattlesContainingRobot = $this->db->findBy('robot_battle', ['robot_id' => $id]);
        foreach ($rawBattlesContainingRobot as $rawBattle){
            $this->db->delete('battle', $rawBattle['battle_id']);
        }

        $this->db->delete('robot', $id);
        $this->db->closeConnection();
    }
}