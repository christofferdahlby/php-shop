<?php
require 'vendor/autoload.php';

class UserDatabase
{
    private $pdo;
    private $auth;

    function getAuth()
    {
        return $this->auth;
    }
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->auth = new \Delight\Auth\Auth($pdo);
    }

    function setupUsers()
    {
    }



    function seedUsers()
    {
        if ($this->pdo->query("select * from users where email='christofferdahlby@gmail.com'")->rowCount() == 0) {
            $userId = $this->auth->admin()->createUser("christofferdahlby@gmail.com", "Hejsan123#", "christofferdahlby@gmail.com");
        }
    }

}
?>