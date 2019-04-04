<?php

class LoginController {

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function loginAction() {
        if (isset($_POST['userName']) && isset($_POST['password'])) {
            $userName = $_POST['userName'];
            $password = $_POST['password'];
            $status = $this->userExist($userName, $password);

            if ($status == 1) {
                setcookie("login", 1, time() + 60, "/");
                header("Location: index.php?controller=welcome&action=welcome");
            } elseif ($status == 2) {
                setcookie("error", "Klaida, prisijungti nepavyko ", time() + 15, "/");
            }
        } else {
            include("views/login.php");
        }
    }

    public function logoutAction() {
        if (isset($_POST['logout'])) {
            setcookie("login", 1, time() - 60, "/");
            header("Location: index.php?controller=login&action=login");
        }
    }

    private function userExist($userName, $password) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName' AND password='$password'";
        $result = $this->connection->query($sqlQuery);
        if ($result->num_rows > 0) {
            return $status = 1;
        } else {
            return $status = 2;
        }
    }

}
