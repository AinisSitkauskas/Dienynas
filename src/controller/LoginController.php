<?php

class LoginController {

    const COOKIE_EXPIRE_TIME = 3600;

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function loginAction() {

        if (empty($_POST['userName']) && empty($_POST['password'])) {
            include("views/login.php");
        } else {
            $userName = $_POST['userName'];
            $password = $_POST['password'];
            $status = $this->userExist($userName, $password);

            if ($status == FALSE) {
                include("views/error.php");
            } elseif ($status == TRUE) {
                setcookie("login", 'login', time() + self::COOKIE_EXPIRE_TIME, "/");
                $_GET['controller'] = "welcome";
                $_GET['action'] = "welcome";
                header("Location: index.php");
            }
        }
    }

    public function logoutAction() {
        if (isset($_POST['logout'])) {
            setcookie("login", 'logout', time() - self::COOKIE_EXPIRE_TIME, "/");
            $_GET['controller'] = "login";
            $_GET['action'] = "login";
            header("Location: index.php");
        }
    }

    private function userExist($userName, $password) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName' AND password='$password'";
        $result = $this->connection->query($sqlQuery);
        if ($result->num_rows > 0) {
            return $status = TRUE;
        } else {
            return $status = FALSE;
        }
    }

}
