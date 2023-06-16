<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/View/';

require __DIR__ . '/Controller/RobotController.php';
require __DIR__ . '/Controller/BattleController.php';
$robotController = new App\Controller\RobotController();
$battleController = new App\Controller\BattleController();

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/robot/':
        require __DIR__ . $viewDir . 'robot.php';
        break;
    case '/battle/':
        require __DIR__ . $viewDir . 'battle.php';
        break;
    case '/robot/get/':
        echo $robotController->getRobots();
        break;
    case '/robot/options/':
        echo $robotController->getOptions();
        break;
    case '/robot/alter/':
        if ($_POST['robot-id'] != null) {
            echo $robotController->updateRobot();
        } else {
            echo $robotController->createRobot();
        }
        header("Location: /robot");
        break;
    case '/robot/delete/':
        $encodedId = isset($_SERVER['HTTP_X_DELETE_ID']) ? $_SERVER['HTTP_X_DELETE_ID'] : null;
        $decodedId = urldecode($encodedId);
        echo $robotController->removeRobot($decodedId);
        break;
    case '/battle/get/':
        echo $battleController->getBattles();
        break;
    case '/battle/alter/':
        if ($_POST['battle-id'] != null) {
//            echo $battleController->updateBattle();
        } else {
            echo $battleController->createBattle();
        }
        header("Location: /battle");
        break;
    case '/battle/delete/':
        $encodedId = isset($_SERVER['HTTP_X_DELETE_ID']) ? $_SERVER['HTTP_X_DELETE_ID'] : null;
        $decodedId = urldecode($encodedId);
        echo $battleController->removeRobot($decodedId);
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
