<?php

class UserDTO {

    /**
     *
     * @var array 
     */
    private $userInformation;

    /**
     *
     * @var string
     */
    private $password;

    function __construct($password, $userInformation) {
        $this->userInformation = $userInformation;
        $this->userInformation = $password;
    }

    /**
     * 
     * @param string $password
     * @return string
     */
    public function getPassword($password) {
        return $password;
    }

    /**
     * 
     * @param array $userInformation
     * @return string
     */
    public function getHashedPassword($userInformation) {
        return $userInformation["password"];
    }

    /**
     * 
     * @param array $userInformation
     * @return string
     */
    public function getUniqueSalt($userInformation) {
        return $userInformation["salt"];
    }

    /**
     * 
     * @param array $userInformation
     * @return string
     */
    public function getHashTimes($userInformation) {
        return $userInformation["hashTimes"];
    }

}
