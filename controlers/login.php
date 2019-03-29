<?php
class loginStatus {

    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    public function getLoginStatus($userName, $password) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName' AND password='$password'";
        $result = $this->connection->query($sqlQuery);
        if ($result->num_rows > 0) {
            return $status = 1;
        } else {
            return $status = 2;
        }
    }

}

include('../connection.php');
if (isset($_POST['userName']) && isset($_POST['password'])) {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $object = new loginStatus($connection);
    $status = $object->getLoginStatus($userName, $password);
    $connection->close();

    if ($status == 1) {
        setcookie("login", 1, time() + 60, "/");
        header("Location: ../views/welcome.php");
    } elseif ($status == 2) {
        setcookie("error", "Klaida, prisijungti nepavyko ", time() + 15, "/");
    }
}
if (isset($_COOKIE['login'])) {
    header("Location: ../views/welcome.php");
} else {
    header("Location: ../views/dienynas_login.php");
}
if (isset($_POST['logout'])) {
    setcookie("login", 1, time() - 60, "/");
    header("Location: ../views/dienynas_login.php");
}
