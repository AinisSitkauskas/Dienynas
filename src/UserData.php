<?php

class UserData {

    /**
     *
     * @var connection 
     */
    private $connection;

    function __construct($connection) {
        $this->connection = $connection;
    }

    /**
     * 
     * @param string $userName
     * @return array or boolean
     */
    public function getUserData($userName) {
        $sqlQuery = "SELECT * FROM users WHERE userName='$userName'";
        $result = $this->connection->query($sqlQuery);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return FALSE;
        }
    }

}
