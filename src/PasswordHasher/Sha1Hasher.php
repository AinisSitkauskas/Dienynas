<?php

include_once("src/PasswordHasher.php");

class Sha1Hasher implements PasswordHasher {

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

    public function passwordsEqual($password, $row) {

        $uniqueSalt = $row["salt"];
        $hashedPassword = $uniqueSalt . $password;
        $n = $row["hashTimes"];

        for ($i = 0; $i < $n; $i++) {
            $hashedPassword = sha1($hashedPassword);
        }

        return $hashedPassword == $row["password"];
    }

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
