<?php

class PublicException extends Exception {

    public function errorMessage($error) {
        return $error;
    }

}
