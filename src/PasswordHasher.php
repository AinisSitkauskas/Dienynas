<?php

interface PasswordHasher {

    public function passwordsEqual($userName, $password);

    public function hashPassword($password);
}
