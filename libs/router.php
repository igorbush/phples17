<?php
$params = [];
$pathList = preg_split('/\//', $_SERVER['REQUEST_URI'], -1, PREG_SPLIT_NO_EMPTY);
array_shift($pathList);
if (count($pathList) < 2) {
    if (!isset($_SESSION['user'])) 
    {
        include 'controllers/mainController.php';
        $main = new mainController();
        $main->getMain();
    } else {
        include 'controllers/taskController.php';
        $main = new taskController($db, $twig);
        $main->getTask();
    }
} elseif (count($pathList) >= 2) {
    $none = array_shift($pathList);
    $controller = array_shift($pathList);
    $action = array_shift($pathList);
    if ($controller == 'taskController') {
        include 'controllers/taskController.php';
        $tasks = new taskController($db, $twig);
        if(($action == 'getTask')) {
            $tasks->getTask();
        }
        if(($action == 'redakt')) {
            if(isset($_POST['done'])){
                $tasks->getDone();
            }
            if(isset($_POST['delete'])){
                $tasks->getDelete();
            }
            if(isset($_POST['edit'])){
                $tasks->getEdit();
            }
        }
        if(($action == 'add')) {
            $tasks->add();
        }
        if(($action == 'changeAssigned')) {
            $tasks->changeAssigned();
        }
    }
    if ($controller == 'userController') {
        include 'controllers/userController.php';
        $user = new userController($db, $twig);

        if(($action == 'logout')) {
            $user->logout();
        }

        if ($action == 'getForm') {
                $user->getForm();

        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['register']) && $action == 'register') {
                $user->register();
            } elseif (isset($_POST['sign_in']) && $action == 'register') {
                $user->signIn();
            }
        }
    }
}