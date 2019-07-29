<?php

include("parameters.php");
include_once("src/Exception/PrivateException.php");

try {
    $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    throw new PrivateException("Connection failed", 0, $error);
}
