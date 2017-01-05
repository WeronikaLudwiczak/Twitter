<?php

use src\classes\User as User;


class userTest extends PHPUnit_Extensions_Database_TestCase
{


    static private $pdo = null;
    private $conn = null;


    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }


    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet('fixture.xml');
    }


    public function testRowCount()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('User'));
    }

    public function testSaveToDb()
    {

        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $email = "user3@wp.pl";
        $userName = "user3";
        $password1 = "password3";
        $password2 = "password3";

        $user = new User();

        $user->setEmail($email);
        $user->setPassword($password1, $password2);
        $user->setUsername($userName);
        $user->saveToDB($conn);

        $this->assertEquals(3, $this->getConnection()->getRowCount('User'));


    }

    public function testLoadUserById()
    {

        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $userId = 40;

        $user = User::loadUserById($conn, $userId);
        $this->assertEquals("user1", $user->getUsername());

    }

    public function testLoadAllUsers()
    {
        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);

        $users = User::loadAllUsers($conn);

        $this->assertEquals(2, count($users));
        $this->assertEquals("user1", $users[0]->getUsername());
        $this->assertNotEquals(0, $users);


    }

    public function testLogIn()
    {
        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);

        $email = 'user1@wp.pl';
        $password = 'pass'; //wrong password

        $this->assertNull(User::LogIn($conn, $email, $password));


    }

    public function testDeleteUser()
    {
        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $user = User::loadUserById($conn, 40);
        $user->delete($conn);

        $this->assertEquals(1, $this->getConnection()->getRowCount('User'));

    }


}