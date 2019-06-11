<?php

include_once('connection.php');
include_once("src/Controller/LoginController.php");
include_once("src/Controller/WelcomeController.php");
include_once("src/Controller/UserController.php");

if (empty($_GET['controller']) || $_GET['controller'] == "welcome") {
    $controller = new WelcomeController($connection);

    if (empty($_GET['action']) || $_GET['action'] == "welcome") {
        $controller->welcomeAction();
    }
} elseif ($_GET['controller'] == "login") {
    $controller = new LoginController($connection);
    switch ($_GET['action']) {
        case "login" :
            $controller->loginAction();
            break;
        case "logout" :
            $controller->logoutAction();
            break;
    }
} elseif ($_GET['controller'] == "user") {
    $controller = new UserController($connection);
    switch ($_GET['action']) {
        case "register" :
            $controller->registerAction();
            break;
        case "delete" :
            $controller->deleteAction();
            break;
    }
}
