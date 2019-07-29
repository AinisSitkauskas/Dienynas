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

        if (!$this->registerUser($userName, $user)) {
            throw new PrivateException;
        }

        include("views/succsesfulRegistration.php");
    }

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function userExist($userName) {
        $sqlQuery = $this->connection->prepare("SELECT * FROM users WHERE userName=:userName");
        $sqlQuery->bindParam(':userName', $userName);
        $sqlQuery->execute();
        $sqlQuery->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sqlQuery->fetchColumn();
        return $result > 0;
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


        $sqlQuery = $this->connection->prepare($sqlQuerry = "INSERT INTO users (userName, password, salt, hashTimes) VALUES (:userName, :password, :salt, :hashTimes)");
        $sqlQuery->bindParam(':userName', $userName);
        $sqlQuery->bindParam(':password', $hashedPassword);
        $sqlQuery->bindParam(':salt', $salt);
        $sqlQuery->bindParam(':hashTimes', $hashTimes);
        return $sqlQuery->execute() === TRUE;
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

        if (!$this->deleteUser($userName)) {
            throw new PrivateException;
        }

        session_unset();
        include("views/userDeleted.php");
    }

    /**
     * 
     * @param string $userName
     * @return boolean
     */
    private function deleteUser($userName) {
        $sqlQuery = $this->connection->prepare($sqlQuerry = "DELETE FROM users WHERE userName = :userName");
        $sqlQuery->bindParam(':userName', $userName);
        return $sqlQuery->execute() === TRUE;
    }

}
