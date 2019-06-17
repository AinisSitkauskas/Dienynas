<?php

class CustomException extends Exception {

    public function errorMessage($error) {

        include("views/error.php");
        exit();
    }

}
