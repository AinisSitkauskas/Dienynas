<?php

class RegistrationController {

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function registrationAction() {

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

        if (!$this->checkLenght($userName)) {
            $error = "Užsiregistruoti nepavyko vartotojo vardas per trumpas";
            include("views/error.php");
            return;
        }

        if (!$this->checkLenght($password)) {
            $error = "Užsiregistruoti nepavyko slaptažodis per trumpas";
            include("views/error.php");
            return;
        }

        if (!$this->userRegistration($userName, $password)) {
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

    private function checkLenght($account) {
        if (strlen($account) > 3) {
            return TRUE;
        }
    }

    private function userRegistration($userName, $password) {
        $sqlQuerry = "INSERT INTO users (userName, password) VALUES ('$userName', '$password')";
        return $this->connection->query($sqlQuerry) === TRUE;
    }

}
