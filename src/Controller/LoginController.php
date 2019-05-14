<?php

class LoginController {

    const COOKIE_EXPIRE_TIME = 3600;

    /**
     *
     * @var mysqli connection
     */
    private $connection;

    /**
     *
     * @var PasswordHasher
     */
    private $passwordHasher;

    function __construct($connection, $passwordHasher) {
        $this->connection = $connection;
        $this->passwordHasher = $passwordHasher;
    }

    public function loginAction() {
        if (empty($_POST['userName']) || empty($_POST['password'])) {
            include("views/login.php");
            return;
        }

        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $row = $this->getUserRow($userName);
        if ($row == FALSE) {
            $error = "Klaida, prisijungti nepavyko! ";
            include("views/error.php");
            return;
        }

        $userDTO = new UserDTO($password, $row);

        if (!$this->passwordHasher->passwordsEqual($userDTO)) {
            $error = "Prisijungti nepavyko, jūsų slaptažodis neteisingas! ";
            include("views/error.php");
            return;
        }

        setcookie("login", $userName, time() + self::COOKIE_EXPIRE_TIME, "/");
        $_GET['controller'] = "welcome";
        $_GET['action'] = "welcome";
        header("Location: index.php");
    }

    public function logoutAction() {
        if (isset($_POST['logout'])) {
            setcookie("login", 'logout', time() - self::COOKIE_EXPIRE_TIME, "/");
            header("Location: index.php");
        }
    }

    /**
     * 
     * @param string $userName
     * @return array OR boolean
     */
    private function getUserRow($userName) {
        $sqlQuery = "SELECT password, salt, hashTimes FROM users WHERE userName='$userName'";
        $result = $this->connection->query($sqlQuery);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return FALSE;
        }
    }

}
