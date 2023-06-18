<?php

namespace App\Controller;

include "./Modal/BattleModal.php";

use App\Modal\BattleModal;
use App\Modal\HtmlTableModal;

class BattleController
{
    private $battleModal;
    private $htmlTableModal;

    public function __construct()
    {
        $this->htmlTableModal = new HtmlTableModal();
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
        if ( $_POST['battle-winner'] !==  $_POST['r-1-select'] && $_POST['battle-winner'] !==  $_POST['r-2-select']) return json_encode('failed');
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
        $this->battleModal->updateBattle(
            $_POST['battle-id'],
            $_POST['battle-date'],
            $_POST['battle-type']
        );
        return json_encode('success');
    }

    public function removeBattle()
    {
        $encodedId = isset($_SERVER['HTTP_X_DELETE_ID']) ? $_SERVER['HTTP_X_DELETE_ID'] : null;
        $id = urldecode($encodedId);
        $this->battleModal->deleteBattle($id, true);
        header('Content-Type: application/json');
        return json_encode("success");
    }

    public function getScoreBoard()
    {
        return $this->battleModal->getScoreBoard();
    }


}