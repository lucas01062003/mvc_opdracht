<?php

namespace App\Modal;

//
//include  "./Repository/RobotRepository.php";
include "./Repository/BattleRepository.php";
//use App\Entity\Robot;
//use App\Entity\Battle;
//use App\Repository\RobotRepository;
//use App\Repository\BattleRepository;
use App\Entity\Battle;
use App\Repository\BattleRepository;
use App\Repository\RobotRepository;

class BattleModal
{
    private $robotRepository;
    private $battleRepository;
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
        $this->battleRepository = new BattleRepository();
    }

    public function getBattles()
    {
        $rawBattles = $this->battleRepository->findAll(true );

        $battles = null;
        foreach ($rawBattles as $rawBattle) {
            $battles[] = [
                "id" => $rawBattle->getId(),
                "robot1" => $rawBattle->getRobots()[0]->getName(),
                "robot2" => $rawBattle->getRobots()[1]->getName(),
                "date" => $rawBattle->getDate(),
                "type" => $rawBattle->getType(),
                "winner" => $rawBattle->getWinner()->getName()
            ];
        }
        return $battles;
    }

    public function createBattle($id, $date, $type, $participant1, $participant2, $winnerId)
    {
        $this->db->openConnection();
        $robots[] = $this->robotRepository->findOneById($participant1);
        $robots[] = $this->robotRepository->findOneById($participant2);
        $winner = $this->robotRepository->findOneById($participant2);
        $battle = new Battle($id, $date, $type, $robots, $winnerId);
        $this->db->createRecord("battle", ["date" => $battle->getDate(), "type" => $battle->getType(), "winner_id" => $battle->getWinner()]);
        $battle->setId($this->db->findLastCreatedRecord("battle")['id']);
        $this->db->createRecord("robot_battle", ["robot_id" => $participant1, "battle_id" => $battle->getId()]);
        $this->db->createRecord("robot_battle", ["robot_id" => $participant2, "battle_id" => $battle->getId()]);
        $this->db->closeConnection();
    }

    public function updateBattle($id, $date, $type){

    }

    public function deleteBattle($id, $persist = false)
    {
        $this->db->delete('battle', $id, $persist);
    }
}