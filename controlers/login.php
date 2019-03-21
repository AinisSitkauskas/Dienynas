<?php
include('../connection.php');
include("../models/user_login.php");
$userName = $_POST['userName'];
$password = $_POST['password'];
$object = new loginStatus($connection);
$status = $object->getLoginStatus($userName, $password);
if ($status == 1) {
    setcookie("login", 1, time() + 60, "/");
} else {
    setcookie("error", "Klaida, prisijungti nepavyko ", time() + 15, "/");
}
$connection->close();

if (isset($_COOKIE['login'])) {
    include("../views/welcome_page.php");
} else {
    header("Location: ../dienynas_login.php");
}







