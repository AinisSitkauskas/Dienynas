<?php
include("parameters.php");
$connection = new mysqli($serverName, $userName, $password, $dbName);
if ($connection->connect_error) {
    $error = "Prisijungti nepavyko: " . mysqli_connect_error();
    echo "Prisijungti nepavyko: " . mysqli_connect_error();
}
