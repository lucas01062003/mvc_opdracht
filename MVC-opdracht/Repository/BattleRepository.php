<?php

namespace App\Repository;

//use App\Modal\DatabaseModal;
//use App\Entity\Robot;
//use App\Entity\Battle;

include "./Entity/Battle.php";

use App\Entity\Battle;
use App\Entity\Robot;
use App\Modal\DatabaseModal;

class BattleRepository
{
    public $db;
    public $robotRepository;
    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
    }

    public function findAll(){

        $battles = [];
        $this->db->openConnection();
        $rawBattles = $this->db->findAllByTable('battle');

        foreach ($rawBattles as $rawBattle) {
            $winningRobot = $this->robotRepository->findOneById($rawBattle['winner_id']);

            $battle = new Battle($rawBattle['id'], $rawBattle['date'], $rawBattle['type'], null, $winningRobot);

            $rawBattleRobots = $this->db->findRelatedRecords('battle', 'robot', 'robot_battle', $battle->getId());
            $robots = [];
            foreach ($rawBattleRobots as $rawBattleRobot){
                $robot = new Robot($rawBattleRobot['id'], $rawBattleRobot['name'], $rawBattleRobot['owner'], $rawBattleRobot['weapon'], $rawBattleRobot['armour'], $rawBattleRobot['propulsion']);
                $robots[] = $robot;
            }
            $battle->setRobots($robots);


            $battles[] = $battle;
        }
        $this->db->closeConnection();
        return $battles;
    }
}