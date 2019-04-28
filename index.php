<?php

define("SESSION_LIFETIME", "2678400");
session_set_cookie_params(SESSION_LIFETIME, "/");
session_start();

include_once('connection.php');
include_once("src/controller/LoginController.php");
include_once("src/controller/WelcomeController.php");
include_once("src/controller/UserController.php");

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
