<?php

class UserDTO {

    /**
     *
     * @var string
     */
    private $password;

    /**
     *
     * @var string
     */
    private $hashedPassword;

    /**
     *
     * @var string 
     */
    private $uniqueSalt;

    /**
     *
     * @var integer
     */
    private $hashTimes;

    /**
     * 
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * 
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

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
     * @param string $uniqueSalt
     */
    public function setUniqueSalt($uniqueSalt) {
        $this->uniqueSalt = $uniqueSalt;
    }

    /**
     * 
     * @return string
     */
    public function getUniqueSalt() {
        return $this->uniqueSalt;
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
