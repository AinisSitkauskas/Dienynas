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

        try {
            if ($this->userExist($userName)) {
                throw new CustomException;
            }
        } catch (CustomException $exception) {
            $error = "Užsiregistruoti nepavyko, toks vartotojo vardas jau egzistuoja";
            $exception->errorMessage($error);
        }

        try {
            if (strlen($userName) < 4) {
                throw new CustomException;
            }
        } catch (CustomException $exception) {
            $error = "Užsiregistruoti nepavyko, vartotojo vardas per trumpas";
            $exception->errorMessage($error);
        }

        try {
            if (strlen($password) < 4) {
                throw new CustomException;
            }
        } catch (CustomException $exception) {
            $error = "Užsiregistruoti nepavyko, slaptažodis per trumpas";
            $exception->errorMessage($error);
        }


        $user = new User();
        $this->passwordHasher->setPassword($password, $user);

        try {
            if (!$this->registerUser($userName, $user)) {
                throw new CustomException;
            }
        } catch (CustomException $exception) {
            $error = "Klaida, užsiregistruoti nepavyko";
            $exception->errorMessage($error);
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

        try {
            if ($userName == "admin") {
                throw new CustomException;
            }
        } catch (CustomException $exception) {
            $error = "Administratoriaus ištrinti negalima";
            $exception->errorMessage($error);
        }

        try {
            if (!$this->deleteUser($userName)) {
                throw new CustomException;
            }
        } catch (CustomException $exception) {
            $error = "Klaida, ištrinti vartotojo nepavyko";
            $exception->errorMessage($error);
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
