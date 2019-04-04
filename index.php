<?php

include_once('connection.php');
include_once("src/controller/LoginController.php");
include_once("src/controller/WelcomeController.php");

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
} 
