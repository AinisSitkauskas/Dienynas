<?php

class LoginController {

    const COOKIE_EXPIRE_TIME = 3600;

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

        $passwordHasher = new PasswordHasher();
        $hashedAndSaltedPassword = $passwordHasher->hashAndSaltPassword($userName, $password);

        if (!$this->userExist($userName, $hashedAndSaltedPassword)) {
            $error = "Klaida, prisijungti nepavyko! ";
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

    private function userExist($userName, $hashedAndSaltedPassword) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName' AND password='$hashedAndSaltedPassword'";
        $result = $this->connection->query($sqlQuery);
        return $result->num_rows > 0;
    }

}
