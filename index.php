<?php

define("SESSION_LIFETIME", "2678400");
session_set_cookie_params(SESSION_LIFETIME, "/");
session_start();

include_once("src/Controller/LoginController.php");
include_once("src/Controller/WelcomeController.php");
include_once("src/Controller/UserController.php");
include_once("src/PasswordHasher/Md5Hasher.php");
include_once("src/PasswordHasher/Sha1Hasher.php");
include_once("src/PasswordHasher.php");
include_once("src/Entity/User.php");
include_once("src/Exception/PrivateException.php");
include_once("src/Exception/PublicException.php");

try {

    include_once('connection.php');

    $passwordHasher = new Sha1Hasher();

    if (empty($_GET['controller']) || $_GET['controller'] == "welcome") {
        $controller = new WelcomeController($connection);

        if (empty($_GET['action']) || $_GET['action'] == "welcome") {
            $controller->welcomeAction();
        }
    } elseif ($_GET['controller'] == "login") {
        $controller = new LoginController($connection, $passwordHasher);
        switch ($_GET['action']) {
            case "login" :
                $controller->loginAction();
                break;
            case "logout" :
                $controller->logoutAction();
                break;
        }
    } elseif ($_GET['controller'] == "user") {
        $controller = new UserController($connection, $passwordHasher);
        switch ($_GET['action']) {
            case "register" :
                $controller->registerAction();
                break;
            case "delete" :
                $controller->deleteAction();
                break;
        }
    }
} catch (PublicException $exception) {
    $error = $exception->getMessage();
    include("views/error.php");
} catch (PrivateException $exception) {
    // Log real exception
    $error = "Įvyko klaida";
    include("views/error.php");
} catch (PDOException $exception) {
    // Log real exception
    $error = "Įvyko klaida";
    include("views/error.php");
} 
