<?php

class LoginController {

    /**
     *
     * @var Database 
     */
    private $database;

    /**
     *
     * @var PasswordHasher 
     */
    private $passwordHasher;

    /**
     * 
     * @param Database $database
     * @param PasswordHasher $passwordHasher
     */
    function __construct($database, $passwordHasher) {
        $this->database = $database;
        $this->passwordHasher = $passwordHasher;
    }

    public function loginAction() {

        if (empty($_POST['userName']) || empty($_POST['password'])) {
            include("views/login.php");
            return;
        }

        $userName = $_POST['userName'];
        $password = $_POST['password'];

        $user = $this->database->getUser($userName);

        if (!$user) {
            throw new PublicException("Prisijungti nepavyko, jūsų vartotojo vardas arba slaptažodis neteisingas!");
        }

        if (!$this->passwordHasher->passwordsEqual($password, $user)) {
            throw new PublicException("Prisijungti nepavyko, jūsų vartotojo vardas arba slaptažodis neteisingas!");
        }

        $_SESSION['userName'] = $userName;
        $_GET['controller'] = "welcome";
        $_GET['action'] = "welcome";
        header("Location: index.php");
    }

    public function logoutAction() {

        if (isset($_POST['logout'])) {
            session_unset();
            header("Location: index.php");
        }
    }

}
