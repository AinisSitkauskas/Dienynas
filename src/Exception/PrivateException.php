<?php

class PrivateException extends Exception {

    public function errorMessage() {
        $error = "Įvyko klaida, bandykite dar kartą";
        return $error;
    }

}
