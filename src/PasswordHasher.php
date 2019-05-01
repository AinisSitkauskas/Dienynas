<?php

interface PasswordHasher {

    public function hashAndLoginPassword($password, $row);

    public function hashAndRegisterPassword($password);
}
