<?php

class LoginController {

    const COOKIE_EXPIRE_TIME = 2678400;

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function loginAction() {

        if (empty($_POST['userName']) || empty($_POST['password'])) {
            include("views/login.php");
            return;
        }

        $userName = $_POST['userName'];
        $password = $_POST['password'];

        if (!$this->userExist($userName, $password)) {
            $error = "Klaida, prisijungti nepavyko! ";
            include("views/error.php");
            return;
        }

        if (!$this->createSessionID($userName)) {
            $error = "Klaida, prisijungti nepavyko! ";
            include("views/error.php");
            return;
        }

        $_SESSION["userName"] = $userName;
        $_GET['controller'] = "welcome";
        $_GET['action'] = "welcome";
        header("Location: index.php");
    }

    public function logoutAction() {
        if (isset($_POST['logout'])) {

            if (!$this->deleteSessionID()) {
                $error = "Klaida, atsijungti nepavyko! ";
                include("views/error.php");
                return;
            }

            setcookie("sessionID", 'logout', time() - self::COOKIE_EXPIRE_TIME, "/");
            session_unset();
            header("Location: index.php");
        }
    }

    private function userExist($userName, $password) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName' AND password='$password'";
        $result = $this->connection->query($sqlQuery);
        return $result->num_rows > 0;
    }

    private function createSessionID($userName) {
        $sessionID = "dhfjdhfjhdsjfh" . $userName . "skjdjskdjks" . $password . "ssdsdsdjsdj";

        for ($i = 0; $i < 5424; $i++) {
            $sessionID = sha1($sessionID);
        }
        $sqlQuerry = "INSERT INTO sessionid (userName, sessionID) VALUES ('$userName', '$sessionID')";
       
        if ($this->connection->query($sqlQuerry) === TRUE) {
            setcookie("sessionID", $sessionID, time() + self::COOKIE_EXPIRE_TIME, "/");
            return TRUE;
        }
    }

    private function deleteSessionID() {
        $sqlQuerry = "DELETE FROM sessionid";
        return $this->connection->query($sqlQuerry) === TRUE;
    }

}
