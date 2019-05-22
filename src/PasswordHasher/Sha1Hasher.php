<?php

include_once("src/PasswordHasher.php");

class Sha1Hasher implements PasswordHasher {

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
     * @param UserDTO
     * @return boolean
     */
    public function passwordsEqual($password, $user) {

        $uniqueSalt = $user->getSalt();
        $hashedPassword = $uniqueSalt . $password;
        $n = $user->getHashTimes();

        for ($i = 0; $i < $n; $i++) {
            $hashedPassword = sha1($hashedPassword);
        }

        return $hashedPassword === $user->getHashedPassword();
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
