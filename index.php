<?php

include_once('connection.php');
include_once("src/controller/LoginController.php");
include_once("src/controller/WelcomeController.php");
include_once("src/controller/RegistrationController.php");

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
} elseif ($_GET['controller'] == "registration") {
    $controller = new RegistrationController($connection);

    if ($_GET['action'] == "registration") {
        $controller->registrationAction();
    }
}