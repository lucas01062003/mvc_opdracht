<?php

namespace App\Controller;

include "./Modal/BattleModal.php";
//
//use App\Modal\BattleModal;
//use App\Modal\RobotModal;
//use App\Modal\HtmlTableModal;


use App\Modal\BattleModal;
use App\Modal\HtmlTableModal;
use App\Modal\RobotModal;

class BattleController
{
    private $robotModal;
    private $battleModal;
    private $htmlTableModal;

    public function __construct()
    {
        $this->htmlTableModal = new HtmlTableModal();
        $this->robotModal = new RobotModal();
        $this->battleModal = new BattleModal();
    }

    public function getBattles()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405); // Method Not Allowed
            return 'Invalid request method.';
        }

        header('Content-Type: application/json');
        return json_encode($this->htmlTableModal->generateTableBody($this->battleModal->getBattles()));
    }

    public function createBattle()
    {
        $this->battleModal->createBattle(
            null,
            $_POST['battle-date'],
            $_POST['battle-type'],
            $_POST['r-1-select'],
            $_POST['r-2-select'],
            $_POST['battle-winner']
        );
        return json_encode('success');
    }

    public function updateBattle()
    {
    }

    public function removeBattle()
    {
    }

}