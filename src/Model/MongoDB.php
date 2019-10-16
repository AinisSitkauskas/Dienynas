<?php

include_once("src/Database.php");

class MongoDB implements Database {

    private $connection;

    function __construct($serverName, $userName, $password, $dbName) {
        $mongo = new MongoDB\Client("mongodb://${userName}:${password}@${serverName}/${dbName}");
        $this->connection = $mongo->$dbName;
    }

    /**
     * 
     * @param string $userName
     * @return User
     */
    public function getUser($userName) {

        $result = $this->connection->user->findOne(
                ['userName' => $userName]
        );

        if (!$result) {
            return NULL;
        }

        $user = new User;
        $user->setHashedPassword($result['password'])
                ->setSalt($result['salt'])
                ->setHashTimes($result['hashTimes']);
        return $user;
    }

    /**
     * 
     * @param User $user
     * @return boolean
     */
    public function userExist($user) {

        $userName = $user->getUserName();
        $result = $this->connection->user->findOne(
                ['userName' => $userName]
        );
        return $result;
    }

    /**
     * 
     * @param User $user
     * @return boolean
     */
    public function registerUser($user) {
        $userName = $user->getUserName();
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

    /**
     * 
     * @param string $user
     * @return boolean
     */
    public function deleteUser($user) {

        $userName = $user->getUserName();
        return $result = $this->connection->user->deleteOne(
                ['userName' => $userName]
        );
    }

}
