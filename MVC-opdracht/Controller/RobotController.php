<?php

namespace App\Controller;

include "./Modal/RobotModal.php";
include "./Modal/HtmlTableModal.php";

use App\Modal\RobotModal;
use App\Modal\HtmlTableModal;

class RobotController
{
    private $robotModal;
    private $htmlTableModal;

    public function __construct()
    {
        $this->htmlTableModal = new HtmlTableModal();
        $this->robotModal = new RobotModal();
    }

    public function getRobots()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405); // Method Not Allowed
            return 'Invalid request method.';
        }
        header('Content-Type: application/json');
        return json_encode($this->htmlTableModal->generateTableBody($this->robotModal->getRobots()));
    }
    public function getOptions(){
        $robots = $this->robotModal->getRobots();

        header('Content-Type: application/json');
        return json_encode($this->htmlTableModal->generateOptions($robots));
    }

    public function createRobot()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            return 'Invalid request method.';
        }
        $this->robotModal->createRobot(null, $_POST['robot-name'], $_POST['robot-owner'], $_POST['robot-weapon'], $_POST['robot-armour'], $_POST['robot-propulsion']);
        return json_encode('success');
    }

    public function updateRobot()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            return 'Invalid request method.';
        }
        $this->robotModal->createRobot($_POST['robot-id'], $_POST['robot-name'], $_POST['robot-owner'], $_POST['robot-weapon'], $_POST['robot-armour'], $_POST['robot-propulsion']);
        return json_encode('success');
    }

    public function removeRobot($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405); // Method Not Allowed
            return 'Invalid request method.';
        }
        $this->robotModal->deleteRobot($id);
        return json_encode('success');
    }
}