<?php

namespace App\Modal;

include "./Repository/BattleRepository.php";

use App\Entity\Battle;
use App\Repository\BattleRepository;
use App\Repository\RobotRepository;

class BattleModal
{
    private $robotRepository;
    private $battleRepository;
    private $db;
    private $htmlTableModal;

    public function __construct()
    {
        $this->db = new DatabaseModal();
        $this->robotRepository = new RobotRepository();
        $this->battleRepository = new BattleRepository();
        $this->htmlTableModal = new HtmlTableModal();
    }

    public function getBattles()
    {
        $rawBattles = $this->battleRepository->findAll(true);

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
        $battle = new Battle($id, $date, $type, $robots, $winnerId);
        $this->db->createRecord(
            "battle",
            ["date" => $battle->getDate(), "type" => $battle->getType(), "winner_id" => $battle->getWinner()]
        );
        $battle->setId($this->db->findLastCreatedRecord("battle")['id']);
        $this->db->createRecord("robot_battle", ["robot_id" => $participant1, "battle_id" => $battle->getId()]);
        $this->db->createRecord("robot_battle", ["robot_id" => $participant2, "battle_id" => $battle->getId()]);
        $this->db->closeConnection();
    }

    public function updateBattle($id, $date, $type)
    {
        $this->db->openConnection();
        $this->db->updateRecord("battle", ["date" => $date, "type" => $type], $id);
        $this->db->closeConnection();
    }

    public function deleteBattle($id, $persist = false)
    {
        $this->db->delete('battle', $id, $persist);
    }

    public function getScoreBoard()
    {
        $this->db->openConnection();
        $winLossPerRobot = [];
        $battles = $this->battleRepository->findAll(true);
        $robots = $this->robotRepository->findAll();
        foreach ($robots as $robot) {
            $win = 0;
            $lose = 0;
            foreach ($battles as $battle) {
                if ($battle->getRobots()[0]->getId() != $robot->getId() && $battle->getRobots()[1]->getId(
                    ) != $robot->getId()) {
                    continue;
                }
                if ($battle->getWinner()->getId() == $robot->getId()) {
                    $win++;
                    continue;
                }
                $lose++;
            }

            $winLossPerRobot[$robot->getId()] = [
                'name' => $robot->getName(),
                'owner' => $robot->getOwner(),
                'win' => $win,
                'lose' => $lose
            ];
        }

        $generatableTable = [];
        foreach ($winLossPerRobot as $winLose) {
            $winPercentage = "0";
            $totalGames = $winLose['win'] + $winLose['lose'];
            if  ($totalGames != 0){
                $winPercentage = number_format((intval($winLose['win']) / $totalGames) * 100);
            }
            $generatableTable[] = [
                "ranking" => "0",
                "robot" => $winLose['name'],
                "owner" => $winLose['owner'],
                "win" => strval($winLose['win']),
                "lose" => strval($winLose['lose']),
                "winPercentage" => $winPercentage
            ];
        }
        $winPercentages = array_column($generatableTable, "win"); // can be changed to winPercentage if preferred
        array_multisort($winPercentages, SORT_DESC, $generatableTable);
        $counter = 0;
        $newGenerateTable = [];
        foreach ($generatableTable as $table){
            $counter++;
            $newTable = $table;
            $newTable['ranking'] = "#" . $counter;
            $newGenerateTable[] = $newTable;
        }
        $generatableTable = $newGenerateTable;
        return $this->htmlTableModal->generateTableBody($generatableTable, 'array');
    }
}