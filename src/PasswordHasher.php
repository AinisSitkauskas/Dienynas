<?php

interface PasswordHasher {

    public function passwordsEqual($password, $row);

    public function hashPassword($password);
}
