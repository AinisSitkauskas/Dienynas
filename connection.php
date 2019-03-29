<?php
include("parameters_login.php");
$connection = new mysqli($serverName, $userName, $password, $dbName);
if ($connection->connect_error) {
    die("Prisijungti nepavyko: " . $conn->connect_error);
}
