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
            $row = $result->fetch_assoc();
            return $status = 1;
        } else {
            return $status = 1;
        }
    }

}
