<?php

class WelcomeController {

    function welcomeAction() {
        
        if (isset($_COOKIE['login'])) {
            include("views/welcome.php");
        }else {
            header("Location: index.php?controller=login&action=login");
        }
    }
}