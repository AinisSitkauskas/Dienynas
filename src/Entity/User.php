<?php

class User {

    /**
     *
     * @var string
     */
    private $hashedPassword;

    /**
     *
     * @var string 
     */
    private $salt;

    /**
     *
     * @var integer
     */
    private $hashTimes;

    /**
     *
     * @var string
     */
    private $userName;

    /**
     * 
     * @param string $hashedPassword
     * @return $this
     */
    public function setHashedPassword($hashedPassword) {
        $this->hashedPassword = $hashedPassword;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    /**
     * 
     * @param string $salt
     * @return $this
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * 
     * @param integer $hashTimes
     * @return $this
     */
    public function setHashTimes($hashTimes) {
        $this->hashTimes = $hashTimes;
        return $this;
    }

    /**
     * 
     * @return integer
     */
    public function getHashTimes() {
        return $this->hashTimes;
    }

    /**
     * 
     * @param string $userName
     * @return $this
     */
    public function setUserName($userName) {
        $this->userName = $userName;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getUserName() {
        return $this->userName;
    }

}
