<?php

class UserController {

    /**
     *
     * @var Database
     */
    private $database;

    /**
     *
     * @var PaswordHasher
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

        $user = new User();
        $user->setUserName($userName);

        if ($this->database->userExist($userName)) {
            throw new PublicException("Užsiregistruoti nepavyko, toks vartotojo vardas jau egzistuoja");
        }

        if (strlen($userName) < 4) {
            throw new PublicException("Užsiregistruoti nepavyko, vartotojo vardas per trumpas");
        }

        if (strlen($password) < 4) {
            throw new PublicException("Užsiregistruoti nepavyko, slaptažodis per trumpas");
        }


        $this->passwordHasher->setPassword($password, $user);

        $this->database->saveUser($user);

        include("views/succsesfulRegistration.php");
    }

    public function deleteAction() {

        if (empty($_SESSION['userName'])) {
            header("Location: index.php");
            return;
        }

        $userName = $_SESSION['userName'];

        $user = new User();
        $user->setUserName($userName);

        if ($userName == "admin") {
            throw new PublicException("Administratoriaus ištrinti negalima");
        }

        $this->database->deleteUser($user);

        session_unset();
        include("views/userDeleted.php");
    }

}
