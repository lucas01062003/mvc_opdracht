<?php

namespace App\Repository;

include "./Entity/Battle.php";

use App\Entity\Battle;
use App\Entity\Robot;
use App\Modal\DatabaseModal;

class BattleRepository
{
    private $db;
    private $robotRepository;
    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
    }

    public function findAll($persist = false){

        $battles = [];
        if ($persist) $this->db->openConnection();
        $rawBattles = $this->db->findAllByTable('battle');

        foreach ($rawBattles as $rawBattle) {
            $battles[] = $this->findOneById($rawBattle['id']);;
        }
        if ($persist) $this->db->closeConnection();
        return $battles;
    }

    public function findOneById($id, $persist=false){
        if ($persist) $this->db->openConnection();

        $rawBattle = $this->db->findBy("battle", ["id" => $id])[0];
        $winningRobot = $this->robotRepository->findOneById($rawBattle['winner_id']);

        $battle = new Battle($rawBattle['id'], $rawBattle['date'], $rawBattle['type'], null, $winningRobot);

        $rawBattleRobots = $this->db->findRelatedRecords('battle', 'robot', 'robot_battle', $battle->getId());
        $robots = [];
        foreach ($rawBattleRobots as $rawBattleRobot){

            $robot = new Robot($rawBattleRobot['robot_id'], $rawBattleRobot['name'], $rawBattleRobot['owner'], $rawBattleRobot['weapon'], $rawBattleRobot['armour'], $rawBattleRobot['propulsion']);
            $robots[] = $robot;
        }
        $battle->setRobots($robots);

        if ($persist) $this->db->closeConnection();
        return $battle;
    }
}