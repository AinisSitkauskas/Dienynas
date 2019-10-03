<?php

class UserController {

    private $connection;

    /**
     *
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * 
     * @param mysqli $connection
     * @param PasswordHasher $passwordHasher
     */
    function __construct($connection, $passwordHasher) {
        $this->connection = $connection;
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


        if ($this->userExist($userName)) {
            throw new PublicException("Užsiregistruoti nepavyko, toks vartotojo vardas jau egzistuoja");
        }

        if (strlen($userName) < 4) {
            throw new PublicException("Užsiregistruoti nepavyko, vartotojo vardas per trumpas");
        }

        if (strlen($password) < 4) {
            throw new PublicException("Užsiregistruoti nepavyko, slaptažodis per trumpas");
        }

        $user = new User();
        $this->passwordHasher->setPassword($password, $user);

        $this->registerUser($userName, $user);

        include("views/succsesfulRegistration.php");
    }

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function userExist($userName) {
        $result = $this->connection->user->findOne(
                ['userName' => $userName]
        );
        return $result;
    }

    /**
     * 
     * @param string $userName
     * @param User $user
     * @return boolean
     */
    private function registerUser($userName, $user) {
        $hashedPassword = $user->getHashedPassword();
        $salt = $user->getSalt();
        $hashTimes = $user->getHashTimes();

        return $this->connection->user->insertOne(
                        ["userName" => $userName,
                            "password" => $hashedPassword,
                            "salt" => $salt,
                            "hashTimes" => $hashTimes]
        );
    }

    public function deleteAction() {

        if (empty($_SESSION['userName'])) {
            header("Location: index.php");
            return;
        }

        $userName = $_SESSION['userName'];

        if ($userName == "admin") {
            throw new PublicException("Administratoriaus ištrinti negalima");
        }

        $this->deleteUser($userName);

        session_unset();
        include("views/userDeleted.php");
    }

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function deleteUser($userName) {

        return $result = $this->connection->user->deleteOne(
                ['userName' => $userName]
        );
    }

}
