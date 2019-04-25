<?php

class UserController {

    const COOKIE_EXPIRE_TIME = 2678400;

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function registerAction() {

        if (empty($_SESSION['userName'])) {
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

        if (empty($_SESSION['userName'])) {
            header("Location: index.php");
            return;
        }

        $userName = $_SESSION['userName'];

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
        setcookie("sessionID", "delete", time() - self::COOKIE_EXPIRE_TIME, "/");
        session_unset();
        include("views/userDeleted.php");
    }

    private function deleteUser($userName) {
        $sqlQuerry = "DELETE FROM users WHERE userName = '$userName'";
        if ($this->connection->query($sqlQuerry) === TRUE) {
            $sqlQuerry = "DELETE FROM sessionid";
            return $this->connection->query($sqlQuerry) === TRUE;
        }
    }

}
