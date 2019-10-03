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
            throw new PublicException("Prisijungti nepavyko, jūsų vartotojo vardas arba slaptažodis neteisingas!");
        }

        if (!$this->passwordHasher->passwordsEqual($password, $user)) {
            throw new PublicException("Prisijungti nepavyko, jūsų vartotojo vardas arba slaptažodis neteisingas!");
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


        $result = $this->connection->user->findOne(
                ['userName' => $userName]
        );

        if (!$result) {
            return NULL;
        }

        $user = new User();
        $user->setHashedPassword($result['password'])
                ->setSalt($result['salt'])
                ->setHashTimes($result['hashTimes']);
        return $user;
    }

}
