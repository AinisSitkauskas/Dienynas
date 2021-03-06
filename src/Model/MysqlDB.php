<?php

include_once("src/Database.php");

class MysqlDB implements Database {

    private $connection;

    function __construct($serverName, $userName, $password, $dbName) {
        $this->connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     *
     * @param string $userName
     * @return User
     */
    public function getUser($userName) {

        $sqlQuery = $this->connection->prepare("SELECT password, salt, hashTimes FROM users WHERE userName=:userName");
        $sqlQuery->bindParam(':userName', $userName);
        $sqlQuery->execute();
        $sqlQuery->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sqlQuery->fetch();
        if (!$row) {
            return NULL;
        }

        $user = new User;
        $user->setHashedPassword($row['password'])
                ->setSalt($row['salt'])
                ->setHashTimes($row['hashTimes']);
        return $user;
    }

    /**
     *
     * @param string $userName
     * @return boolean
     */
    public function userExist($userName) {
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
    public function saveUser($user) {
        $userName = $user->getUserName();
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

    /**
     *
     * @param User $user
     * @return boolean
     */
    public function deleteUser($user) {
        $userName = $user->getUserName();
        $sqlQuery = $this->connection->prepare($sqlQuerry = "DELETE FROM users WHERE userName = :userName");
        $sqlQuery->bindParam(':userName', $userName);
        return $sqlQuery->execute() === TRUE;
    }

}
