<?php

class PasswordHasher {

    const FIXED_SALT_1 = "dhfjdhfjhdsjfh";
    const FIXED_SALT_2 = "skjdjskdjks";
    const FIXED_SALT_3 = "ssdsdsdjsdj";

    public function hashAndSaltPassword($userName, $password) {
        $hashedAndSaltedPassword = self::FIXED_SALT_1 . $userName . self::FIXED_SALT_2 . $password . self::FIXED_SALT_3;

        for ($i = 0; $i < 1000; $i++) {
            $hashedAndSaltedPassword = sha1($hashedAndSaltedPassword);
        }
        return $hashedAndSaltedPassword;
    }

}
