<?php

class WelcomeController {

    function welcomeAction() {

        if (isset($_SESSION['userName'])) {
            include("views/welcome.php");
        } else {
            header("Location: index.php?controller=login&action=login");
        }
    }

}
