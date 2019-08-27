<?php

include("parameters.php");

    $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
