<?php

interface PasswordHasher {

    /**
     * 
     * @param string $password
     * @param User $user
     */
    public function passwordsEqual($password, $user);

    /**
     * 
     * @param string $password
     * @param User $user
     */
    public function setPassword($password, $user);
}
