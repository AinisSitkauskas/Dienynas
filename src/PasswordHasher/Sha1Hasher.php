<?php

include_once("src/PasswordHasher.php");
include_once("src/UserData.php");

class Sha1Hasher implements PasswordHasher {

    /**
     *
     * @var UserData
     */
    private $userData;

    function __construct($userData) {
        $this->userData = $userData;
    }

    /**
     *
     * @param string $password
     * @return array
     */
    public function hashPassword($password) {

        $uniqueSalt = $this->getUniqueSalt();
        $hashedPassword = $uniqueSalt . $password;
        $n = 0;
        $start = microtime(true);

        while (microtime(true) - $start < 1) {
            $hashedPassword = sha1($hashedPassword);
            $n++;
        }

        return $passwordInfo = array($hashedPassword, $uniqueSalt, $n);
    }

    /**
     * 
     * @param string $userName
     * @param string $password
     * @return boolean
     */
    public function passwordsEqual($userName, $password) {

        $userData = $this->userData->getUserData($userName);
        $uniqueSalt = $userData["salt"];
        $hashedPassword = $uniqueSalt . $password;
        $n = $userData["hashTimes"];

        for ($i = 0; $i < $n; $i++) {
            $hashedPassword = sha1($hashedPassword);
        }

        return $hashedPassword == $userData["password"];
    }

    /**
     * 
     * @return string
     */
    private function getUniqueSalt() {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uniqueSalt = '';
        $n = rand(15, 25);

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $uniqueSalt .= $characters[$index];
        }

        return $uniqueSalt;
    }

}
