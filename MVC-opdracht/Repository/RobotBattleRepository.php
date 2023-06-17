<?php

namespace App\Repository;

use App\Entity\RobotBattle;
use App\Modal\DatabaseModal;

class RobotBattleRepository
{
    private $db;
    private $robotRepository;
    private $battleRepository;

    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
        $this->battleRepository = new BattleRepository();
    }

    public function findAll($persist = false){
        if ($persist) $this->db->openConnection();
        $rawRobotBattles = $this->db->findAllByTable('robot_battle');
        $robotBattles = [];
        foreach ($rawRobotBattles as $rawRobotBattle){
            $robotBattles[] = $this->findOneById($rawRobotBattle['robot_id']);
        }
        if($persist) $this->db->closeConnection();
        return $robotBattles;
    }

    public function findOneById($id, $persist = false, $search = null){
        if ($persist) $this->db->openConnection();
        if ($search === null){
            $rawRobotBattle = $this->db->findBy("robot_battle", ['id' => $id]);
        }else{
            $rawRobotBattle = $this->db->findBy("robot_battle", $search);

        }

        $robot = $this->robotRepository->findOneById($rawRobotBattle['robot_id']);
        $battle = $this->battleRepository->findOneById($rawRobotBattle['battle_id']);
        if($persist) $this->db->closeConnection();
        return new RobotBattle($rawRobotBattle['id'], $robot, $battle);
    }



}