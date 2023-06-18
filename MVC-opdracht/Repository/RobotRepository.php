<?php

namespace App\Repository;

include "./Modal/DatabaseModal.php";
include "./Entity/Robot.php";

use App\Modal\DatabaseModal;
use App\Entity\Robot;

class RobotRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseModal();
    }

    public function findAll()
    {
        $robots = [];
        $rawRobots = $this->db->findAllByTable('robot', true);

        foreach ($rawRobots as $rawRobot) {
            $robot = new Robot(
                $rawRobot['id'],
                $rawRobot['name'],
                $rawRobot['owner'],
                $rawRobot['weapon'],
                $rawRobot['armour'],
                $rawRobot['propulsion']
            );
            $robots[] = $robot;
        }
        return $robots;
    }

    public function findOneById($id, $persist = false)
    {
        $rawWinningRobot = $this->db->findBy('robot', ["id" => $id], $persist)[0];
        return new Robot($rawWinningRobot['id'], $rawWinningRobot['name'], $rawWinningRobot['owner'], $rawWinningRobot['weapon'], $rawWinningRobot['armour'], $rawWinningRobot['propulsion']);
    }

}