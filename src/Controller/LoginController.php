<?php

class LoginController {

    const COOKIE_EXPIRE_TIME = 3600;

    /**
     *
     * @var connection
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

    /**
     * 
     * @return NULL
     */
    public function loginAction() {

        if (empty($_POST['userName']) || empty($_POST['password'])) {
            include("views/login.php");
            return;
        }

        $userName = $_POST['userName'];
        $password = $_POST['password'];

        if (!$this->passwordHasher->passwordsEqual($userName, $password)) {
            $error = "Prisijungti nepavyko, jūsų vartotojo vardas arba slaptažodis neteisingas! ";
            include("views/error.php");
            return;
        }

        setcookie("login", $userName, time() + self::COOKIE_EXPIRE_TIME, "/");
        $_GET['controller'] = "welcome";
        $_GET['action'] = "welcome";
        header("Location: index.php");
    }

    /**
     * @return NULL 
     */
    public function logoutAction() {
        if (isset($_POST['logout'])) {
            setcookie("login", 'logout', time() - self::COOKIE_EXPIRE_TIME, "/");
            header("Location: index.php");
        }
    }

}
