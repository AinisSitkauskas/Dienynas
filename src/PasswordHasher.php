<?php

interface PasswordHasher {

    public function passwordsEqual($userDTO);

    public function hashPassword($password);
}
