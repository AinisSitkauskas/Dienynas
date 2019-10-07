<?php

include_once("src/Database.php");

class MongoDB implements Database {

    private $connection;

    function __construct() {
        $mongo = new MongoDB\Client;
        $this->connection = $mongo->dienynas;
    }

    /**
     * 
     * @param User $user
     * @return User
     */
    public function getUser($user) {

        $userName = $user->getUserName();
        $result = $this->connection->user->findOne(
                ['userName' => $userName]
        );

        if (!$result) {
            return NULL;
        }

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
