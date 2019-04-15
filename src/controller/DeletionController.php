<?php

class DeletionController {

    const COOKIE_EXPIRE_TIME = 3600;

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function deletionAction() {

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
