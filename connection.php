<?php
include("parameters.php");
$connection = new mysqli($serverName, $userName, $password, $dbName);
if ($connection->connect_error) {
    die("Prisijungti nepavyko: " . $conn->connect_error);
}
