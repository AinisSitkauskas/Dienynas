<?php

define("SESSION_LIFETIME", "2678400");
session_set_cookie_params(SESSION_LIFETIME, "/");
session_start();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

include_once("vendor/autoload.php");
include_once("src/Controller/LoginController.php");
include_once("src/Controller/WelcomeController.php");
include_once("src/Controller/UserController.php");
include_once("src/PasswordHasher/Md5Hasher.php");
include_once("src/PasswordHasher/Sha1Hasher.php");
include_once("src/PasswordHasher.php");
include_once("src/Model/MongoDB.php");
include_once("src/Model/MysqlDB.php");
include_once("src/Database.php");
include_once("src/Entity/User.php");
include_once("src/Exception/PrivateException.php");
include_once("src/Exception/PublicException.php");
include_once("parameters.php");

try {

    $log = new Logger('name');
    $log->pushHandler(new StreamHandler('log.txt', Logger::WARNING));

    $passwordHasher = new Sha1Hasher();
    $database = new MongoDB($serverName, $userName, $password, $dbName);

    if (empty($_GET['controller']) || $_GET['controller'] == "welcome") {
        $controller = new WelcomeController();

        if (empty($_GET['action']) || $_GET['action'] == "welcome") {
            $controller->welcomeAction();
        }
    } elseif ($_GET['controller'] == "login") {
        $controller = new LoginController($database, $passwordHasher);
        switch ($_GET['action']) {
            case "login" :
                $controller->loginAction();
                break;
            case "logout" :
                $controller->logoutAction();
                break;
        }
    } elseif ($_GET['controller'] == "user") {
        $controller = new UserController($database, $passwordHasher);
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
    $log->error($exception);
    $error = "Įvyko klaida";
    include("views/error.php");
} catch (MongoCursorException $exception) {
    $log->error($exception);
    $error = "Įvyko klaida";
    include("views/error.php");
} catch (\PDOException $exception) {
    $log->error($exception);
    $error = "Įvyko klaida";
    include("views/error.php");
}
