<?php

class UserController {

    const COOKIE_EXPIRE_TIME = 3600;

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function registerAction() {

        if (empty($_COOKIE['login'])) {
            header("Location: index.php");
            return;
        }

        if (empty($_POST['userName']) || empty($_POST['password'])) {
            include("views/registration.php");
            return;
        }

        $userName = $_POST['userName'];
        $password = $_POST['password'];

        if ($this->userExist($userName)) {
            $error = "Užsiregistruoti nepavyko, toks vartotojo vardas jau egzistuoja";
            include("views/error.php");
            return;
        }

        if (strlen($userName) < 4) {
            $error = "Užsiregistruoti nepavyko, vartotojo vardas per trumpas";
            include("views/error.php");
            return;
        }

        if (strlen($password) < 4) {
            $error = "Užsiregistruoti nepavyko, slaptažodis per trumpas";
            include("views/error.php");
            return;
        }

        if (!$this->registerUser($userName, $password)) {
            $error = "Klaida, užsiregistruoti nepavyko";
            include("views/error.php");
            return;
        }

        include("views/succsesfulRegistration.php");
    }

    private function userExist($userName) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName'";
        $result = $this->connection->query($sqlQuery);
        return $result->num_rows > 0;
    }

    private function registerUser($userName, $password) {
        $sqlQuerry = "INSERT INTO users (userName, password) VALUES ('$userName', '$password')";
        return $this->connection->query($sqlQuerry) === TRUE;
    }

    public function deleteAction() {

        if (empty($_COOKIE['login'])) {
            header("Location: index.php");
            return;
        }

        $userName = $_COOKIE['login'];

        if ($userName == "admin") {
            $error = "Administratoriaus ištrinti negalima";
            include("views/error.php");
            return;
        }

        if (!$this->deleteUser($userName)) {
            $error = "Klaida, ištrinti vartotojo nepavyko";
            include("views/error.php");
            return;
        }
        setcookie("login", "delete", time() - self::COOKIE_EXPIRE_TIME, "/");
        include("views/userDeleted.php");
    }

    private function deleteUser($userName) {
        $sqlQuerry = "DELETE FROM users WHERE userName = '$userName'";
        return $this->connection->query($sqlQuerry) === TRUE;
    }

}
