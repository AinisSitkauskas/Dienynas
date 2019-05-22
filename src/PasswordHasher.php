<?php

interface PasswordHasher {

    public function passwordsEqual($password, $user);

    public function hashPassword($password);
}
