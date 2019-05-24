<?php

include_once("src/PasswordHasher.php");

class md5Hasher implements PasswordHasher {

    /**
     * 
     * @param string $password
     * @param User $user
     */
    public function setPassword($password, $user) {

        $uniqueSalt = $this->getUniqueSalt();
        $hashedPassword = $uniqueSalt . $password;
        $n = 0;
        $start = microtime(true);

        while (microtime(true) - $start < 1) {
            $hashedPassword = md5($hashedPassword);
            $n++;
        }
        
        $user->setSalt($uniqueSalt)
             ->setHashTimes($n)
             ->setHashedPassword();
        return;
    }

    /**
     * 
     * @param string $password
     * @param User $user
     * @return boolean
     */
    public function passwordsEqual($password, $user) {

        $uniqueSalt = $user->getSalt();
        $hashedPassword = $uniqueSalt . $password;
        $n = $user->getHashTimes();

        for ($i = 0; $i < $n; $i++) {
            $hashedPassword = md5($hashedPassword);
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
