<?php

class WelcomeController {

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function welcomeAction() {

        if (isset($_SESSION['userName'])) {
            include("views/welcome.php");
        } elseif (isset($_COOKIE['sessionID']) && empty($_SESSION['userName'])) {
            $sessionID = $_COOKIE['sessionID'];

            if (!$this->sessionIDExist($sessionID)) {
                header("Location: index.php?controller=login&action=logout");
                return;
            }

            include("views/welcome.php");
        } else {
            header("Location: index.php?controller=login&action=login");
        }
    }

    private function sessionIDExist($sessionID) {
        $sqlQuery = "SELECT * FROM sessionID WHERE sessionID='$sessionID'";
        $result = $this->connection->query($sqlQuery);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['userName'] = $row["userName"];
            return TRUE;
        }
    }

}
