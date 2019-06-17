<?php

class LoginController {

    private $connection;

    /**
     *
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * 
     * @param mysqli $connection
     * @param PasswordHasher $passwordHasher
     */
    function __construct($connection, $passwordHasher) {
        $this->connection = $connection;
        $this->passwordHasher = $passwordHasher;
    }

    public function loginAction() {

        if (empty($_POST['userName']) || empty($_POST['password'])) {
            include("views/login.php");
            return;
        }

        $userName = $_POST['userName'];
        $password = $_POST['password'];

        $user = $this->getUser($userName);

        if (!$user) {
            $error = "Klaida, prisijungti nepavyko! ";
            include("views/error.php");
            return;
        }

        if (!$this->passwordHasher->passwordsEqual($password, $user)) {
            $error = "Prisijungti nepavyko, jūsų slaptažodis neteisingas! ";
            include("views/error.php");
            return;
        }

        $_SESSION['userName'] = $userName;
        $_GET['controller'] = "welcome";
        $_GET['action'] = "welcome";
        header("Location: index.php");
    }

    public function logoutAction() {
        if (isset($_POST['logout'])) {
            session_unset();
            header("Location: index.php");
        }
    }

    private function getUser($userName) {
        $sqlQuery = $this->connection->prepare("SELECT password, salt, hashTimes FROM users WHERE userName=:userName");
        $sqlQuery->bindParam(':userName', $userName);
        $sqlQuery->execute();
        $sqlQuery->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sqlQuery->fetch();

        if (!$row) {
            return NULL;
        }

        $user = new User();
        $user->setHashedPassword($row['password'])
                ->setSalt($row['salt'])
                ->setHashTimes($row['hashTimes']);
        return $user;
    }

}
