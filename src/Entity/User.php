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
     * @param string $hashedPassword
     * 
     */
    public function setHashedPassword($hashedPassword) {
        $this->hashedPassword = $hashedPassword;
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
     */
    public function setSalt($salt) {
        $this->salt = $salt;
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
     */
    public function setHashTimes($hashTimes) {
        $this->hashTimes = $hashTimes;
    }

    /**
     * 
     * @return integer
     */
    public function getHashTimes() {
        return $this->hashTimes;
    }

}
