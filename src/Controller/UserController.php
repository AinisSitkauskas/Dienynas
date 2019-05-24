<?php

class UserController {

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

    /**
     *
     * @var User
     */
    private $user;

    /**
     * 
     * @param mysqli connection $connection
     * @param PasswordHasher $passwordHasher
     * @param User $user
     */
    function __construct($connection, $passwordHasher, $user) {
        $this->connection = $connection;
        $this->passwordHasher = $passwordHasher;
        $this->user = $user;
    }

    public function registerAction() {

        if (empty($_COOKIE['login'])) {
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

        $this->passwordHasher->setPassword($password, $this->user);

        if (!$this->registerUser($userName)) {
            $error = "Klaida, užsiregistruoti nepavyko";
            include("views/error.php");
            return;
        }

        include("views/succsesfulRegistration.php");
    }

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function userExist($userName) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName'";
        $result = $this->connection->query($sqlQuery);
        return $result->num_rows > 0;
    }

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function registerUser($userName) {
        $hashedPassword = $this->user->getHashedPassword();
        $salt = $this->user->getSalt();
        $hashTimes = $this->user->getHashTimes();

        $sqlQuerry = "INSERT INTO users (userName, password, salt, hashTimes ) VALUES ('$userName', '$hashedPassword', '$salt', '$hashTimes')";
        return $this->connection->query($sqlQuerry) === TRUE;
    }

    public function deleteAction() {

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

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function deleteUser($userName) {
        $sqlQuerry = "DELETE FROM users WHERE userName = '$userName'";
        return $this->connection->query($sqlQuerry) === TRUE;
    }

}
